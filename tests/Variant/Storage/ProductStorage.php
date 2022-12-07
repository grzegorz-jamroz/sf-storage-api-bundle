<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Variant\Storage;

use Ifrost\EntityStorage\Storage\JsonEntityStorage;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;

class ProductStorage extends JsonEntityStorage
{
    public function __construct()
    {
        parent::__construct(Product::class, sprintf('%s/products', TEMPORARY_DATA_DIRECTORY));
    }
}
