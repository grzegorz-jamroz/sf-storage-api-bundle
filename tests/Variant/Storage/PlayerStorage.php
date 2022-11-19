<?php

declare(strict_types=1);

namespace Tests\Variant\Storage;

use Ifrost\EntityStorage\Storage\JsonEntityStorage;
use Tests\Variant\Entity\Product;

class PlayerStorage extends JsonEntityStorage
{
    public function __construct()
    {
        parent::__construct(Product::class, sprintf('%s/players', TEMPORARY_DATA_DIRECTORY));
    }
}
