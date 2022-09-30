<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Controller;

use Ifrost\ApiBundle\Controller\ApiController;
use Ifrost\ApiFoundation\ApiInterface;
use Ifrost\StorageApiBundle\Attribute\Api;
use Ifrost\StorageApiBundle\Collection\StorageCollection;
use Ifrost\StorageApiBundle\Utility\StorageApi;

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

    protected function getApi(): ApiInterface
    {
        $attributes = (new \ReflectionClass(static::class))->getAttributes(Api::class, \ReflectionAttribute::IS_INSTANCEOF);
        $attributes[0] ?? throw new \RuntimeException(sprintf('Controller "%s" has to declare "%s" attribute.', static::class, StorageApi::class));
        ['entity' => $entity, 'storage' => $storage] = $attributes[0]->getArguments();
        $storage = $this->getStorages()->get($storage);

        return new StorageApi($entity, $storage, $this->getApiRequestService());
    }
}
