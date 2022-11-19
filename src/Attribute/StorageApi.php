<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Attribute;

use Ifrost\ApiFoundation\Attribute\Api;
use Ifrost\StorageApiBundle\Utility\Action;

#[\Attribute(\Attribute::TARGET_CLASS)]
class StorageApi extends Api
{
    /**
     * @param array<int, Action|string> $excludedPaths
     */
    public function __construct(
        string $entity,
        protected string $storage,
        protected string $path = '',
        protected array $excludedPaths = [],
    ) {
        parent::__construct($entity);
    }

    public function getStorage(): string
    {
        return $this->storage;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return array<int, Action>
     */
    public function excludedPaths(): array
    {
        return array_reduce(
            $this->excludedPaths,
            function (array $carry, Action|string $excludePath) {
                if ($excludePath instanceof Action) {
                    $carry[] = $excludePath;

                    return $carry;
                }

                if (in_array($excludePath, Action::values())) {
                    $carry[] = Action::fromValue($excludePath);
                }

                return $carry;
            },
            []
        );
    }
}
