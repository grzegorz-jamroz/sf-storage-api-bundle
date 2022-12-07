<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Variant\Entity;

use Ifrost\StorageApiBundle\Entity\EntityInterface;
use PlainDataTransformer\Transform;

class Player implements EntityInterface
{
    public function __construct(
        private string $uuid,
        private string $name,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array<int, string>
     */
    public static function getFields(): array
    {
        return array_keys(self::createFromArray([])->jsonSerialize());
    }

    public static function createFromArray(array $data): static|self
    {
        return new self(
            Transform::toString($data['uuid'] ?? ''),
            Transform::toString($data['name'] ?? ''),
        );
    }

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
        ];
    }
}
