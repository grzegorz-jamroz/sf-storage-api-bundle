<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Controller;

use Ifrost\ApiBundle\Controller\ApiController;
use Ifrost\ApiFoundation\ApiInterface;
use Ifrost\EntityStorage\Storage\EntityStorageInterface;
use Ifrost\StorageApiBundle\Attribute\StorageApi as StorageApiAttribute;
use Ifrost\StorageApiBundle\Collection\StorageCollection;
use Ifrost\StorageApiBundle\Utility\StorageApi;
use PlainDataTransformer\Transform;

class StorageApiController extends ApiController
{
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'ifrost_api.storage.collection' => '?' . StorageCollection::class,
        ]);
    }

    protected function getStorages(): StorageCollection
    {
        $collection = $this->container->get('ifrost_api.storage.collection');
        $collection instanceof StorageCollection ?: throw new \RuntimeException(sprintf('Container identifier "ifrost_api.storage.collection" is not instance of %s', StorageCollection::class));

        return $collection;
    }

    protected function getApi(
        string $entityClassName = '',
        ?EntityStorageInterface $storage = null
    ): ApiInterface {
        if (
            $entityClassName !== ''
            && $storage !== null
        ) {
            return new StorageApi($entityClassName, $storage, $this->getApiRequestService());
        }

        $attributes = (new \ReflectionClass(static::class))->getAttributes(StorageApiAttribute::class, \ReflectionAttribute::IS_INSTANCEOF);
        $attributes[0] ?? throw new \RuntimeException(sprintf('Controller "%s" has to declare "%s" attribute.', static::class, StorageApiAttribute::class));
        $attribute = $attributes[0]->newInstance();

        if ($entityClassName === '') {
            $entityClassName = $attribute->getEntity();
        }

        if ($storage === null) {
            $storageClassName = $attribute->getStorage();
            in_array(EntityStorageInterface::class, Transform::toArray(class_implements($storageClassName))) ?: throw new \InvalidArgumentException(sprintf('Given argument "storage" (%s) has to implement "%s" interface.', $storageClassName, EntityStorageInterface::class));
            $storage = $this->getStorages()->get($storageClassName);
        }

        return new StorageApi($entityClassName, $storage, $this->getApiRequestService());
    }
}
