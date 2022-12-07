<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\Utility\StorageApi;

use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use Ifrost\ApiFoundation\Exception\NotUniqueException;
use Ifrost\StorageApiBundle\Utility\StorageApi;
use Ifrost\StorageApiBundle\Tests\Unit\ProductTestCase;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;

class CreateTest extends ProductTestCase
{
    public function testShouldCreateRequestedProduct()
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();
        $this->assertCount(0, $this->storage->findAll());
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $productData = $this->productsData->get($uuid);
        $request = $this->createMock(ApiRequestInterface::class);
        $request->method('getAttribute')
            ->with('uuid', '')
            ->willReturn($uuid);
        $request->method('getRequest')
            ->with(Product::getFields())
            ->willReturn(
                array_filter(
                    $productData,
                    fn (string $key) => in_array($key, Product::getFields()),
                    ARRAY_FILTER_USE_KEY
                )
            );
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        // When
        $storageApi->create();

        // Then
        $products = $this->storage->findAll();
        $this->assertCount(1, $products);
        $this->assertEquals(
            $this->products->get($uuid),
            $products->first()
        );
    }
    
    public function testShouldThrowNotUniqueExceptionWhenTryingToCreateProductWhichHasNotUniqueUuid()
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $this->expectException(NotUniqueException::class);
        $this->expectExceptionMessage(sprintf('Unable to create "%s" due to not unique fields.', Product::class));
        $productData = $this->productsData->get($uuid);
        $request = $this->createMock(ApiRequestInterface::class);
        $request->method('getAttribute')
            ->with('uuid', '')
            ->willReturn($uuid);
        $request->method('getRequest')
            ->with(Product::getFields())
            ->willReturn(
                array_filter(
                    $productData,
                    fn (string $key) => in_array($key, Product::getFields()),
                    ARRAY_FILTER_USE_KEY
                )
            );
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        // When & Then
        $storageApi->create();
        $storageApi->create();
    }
}
