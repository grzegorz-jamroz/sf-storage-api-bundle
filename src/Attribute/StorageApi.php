<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Attribute;

use Ifrost\ApiFoundation\Attribute\Api;

#[\Attribute(\Attribute::TARGET_CLASS)]
class StorageApi extends Api
{
    public function __construct(
        string $entity,
        protected string $storage,
    ) {
        parent::__construct($entity);
    }

    public function getStorage(): string
    {
        return $this->storage;
    }
}
