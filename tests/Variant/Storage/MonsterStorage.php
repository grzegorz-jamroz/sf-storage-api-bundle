<?php

declare(strict_types=1);

namespace Tests\Variant\Storage;

use Ifrost\EntityStorage\Storage\JsonEntityStorage;
use Tests\Variant\Entity\Product;

class MonsterStorage extends JsonEntityStorage
{
    public function __construct()
    {
        parent::__construct(Product::class, sprintf('%s/monsters', TEMPORARY_DATA_DIRECTORY));
    }
}
