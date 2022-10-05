<?php

declare(strict_types=1);

namespace Tests\Variant\Controller;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Tests\Variant\Entity\Product;
use Tests\Variant\Storage\ProductStorage;

#[StorageApi(entity: Product::class, storage: ProductStorage::class)]
class ProductController extends StorageApiControllerVariant
{
}