<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Attribute;

use Ifrost\ApiFoundation\Attribute\Api;
use Ifrost\ApiFoundation\Enum\Action;

#[\Attribute(\Attribute::TARGET_CLASS)]
class StorageApi extends Api
{
    /**
     * @param array<int, Action|string> $excludedActions
     */
    public function __construct(
        string $entity,
        protected string $storage,
        protected string $path = '',
        protected array $excludedActions = [],
    ) {
        parent::__construct($entity, $path, $excludedActions);
    }

    public function getStorage(): string
    {
        return $this->storage;
    }
}
