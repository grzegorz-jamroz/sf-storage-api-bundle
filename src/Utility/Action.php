<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Utility;

enum Action: string
{
    case FIND = 'find';
    case FIND_ONE = 'findOne';
    case CREATE = 'create';
    case UPDATE = 'update';
    case MODIFY = 'modify';
    case DELETE = 'delete';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function fromValue(string $value): self
    {
        foreach (self::cases() as $action) {
            if ($action->value === $value){
                return $action;
            }
        }

        throw new \InvalidArgumentException(sprintf('There is no %s with value %s', self::class, $value));
    }
}
