<?php

declare(strict_types=1);

namespace Tests\Unit\Attribute\StorageApi;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use PHPUnit\Framework\TestCase;
use Tests\Variant\Entity\Product;
use Tests\Variant\Storage\ProductStorage;

class GetStorageTest extends TestCase
{
    public function testShouldReturnStorageAsString()
    {
        // Given
        $attribute = new StorageApi(Product::class, ProductStorage::class, 'products');

        // When & Then
        $this->assertEquals(ProductStorage::class, $attribute->getStorage());
    }
}
