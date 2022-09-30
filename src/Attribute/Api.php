<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Attribute;

use Ifrost\EntityStorage\Entity\EntityInterface;
use Ifrost\EntityStorage\Storage\EntityStorageInterface;
use PlainDataTransformer\Transform;

#[\Attribute]
class Api
{
    protected string $entity;

    public function __construct(string $entity)
    {
        $this->setEntity($entity);
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    protected function setEntity(string $entity): void
    {
        if (!in_array(EntityInterface::class, Transform::toArray(class_implements($entity)))) {
            throw new \InvalidArgumentException(sprintf('Given argument "entity" (%s) has to implement "%s" interface.', $entity, EntityInterface::class));
        }

        $this->entity = $entity;
    }
}
