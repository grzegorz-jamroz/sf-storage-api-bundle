<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Attribute;

use Ifrost\EntityStorage\Entity\EntityInterface;
use Ifrost\EntityStorage\Storage\EntityStorageInterface;
use PlainDataTransformer\Transform;

#[\Attribute]
class StorageApi extends Api
{
    protected string $storage;

    public function __construct(
        string $entity,
        string $storage,
    ) {
        parent::__construct($entity);
        $this->setStorage($storage);
    }

    public function getStorage(): EntityStorageInterface
    {
        return $this->storage;
    }

    protected function setStorage(string $storage): void
    {
        if (!in_array(EntityStorageInterface::class, Transform::toArray(class_implements($storage)))) {
            throw new \InvalidArgumentException(sprintf('Given argument "storage" (%s) has to implement "%s" interface.', $storage, EntityStorageInterface::class));
        }

        $this->storage = $storage;
    }
}
