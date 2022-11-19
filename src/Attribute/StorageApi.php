<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Attribute;

use Ifrost\ApiFoundation\Attribute\Api;
use Ifrost\StorageApiBundle\Utility\Action;

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
    public function excludedActions(): array
    {
        return array_reduce(
            $this->excludedActions,
            function (array $carry, Action|string $excludedAction) {
                if ($excludedAction instanceof Action) {
                    $carry[] = $excludedAction;

                    return $carry;
                }

                if (in_array($excludedAction, Action::values())) {
                    $carry[] = Action::fromValue($excludedAction);
                }

                return $carry;
            },
            []
        );
    }
}
