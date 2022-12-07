<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\Attribute\StorageApi;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use PHPUnit\Framework\TestCase;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;
use Ifrost\StorageApiBundle\Tests\Variant\Storage\ProductStorage;

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
