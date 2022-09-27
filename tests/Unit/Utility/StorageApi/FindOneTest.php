<?php

declare(strict_types=1);

namespace Tests\Unit\Utility\StorageApi;

use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use Ifrost\ApiFoundation\Exception\NotFoundException;
use Ifrost\StorageApiBundle\Utility\StorageApi;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\Unit\ProductTestCase;
use Tests\Variant\Entity\Product;

class FindOneTest extends ProductTestCase
{
    public function testShouldReturnResponseWithRequestedProduct()
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();
        $productUuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $request = $this->createMock(ApiRequestInterface::class);
        $request->method('getAttribute')->with('uuid', '')->willReturn($productUuid);
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        foreach ($this->productsData as $productData) {
            $this->storage->create(Product::createFromArray($productData));
        }

        $this->assertCount(4, $this->storage->findAll());

        // When
        $response = $storageApi->findOne();

        // Then
        $this->assertEquals(new JsonResponse($this->products->get($productUuid)), $response);
    }
    
    public function testShouldThrowNotFoundExceptionWhenRequestedProductDoesNotExist()
    {
        // Expect & Given
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(sprintf('Record "%s" not found', Product::class));
        $this->tempProductsDirectory->delete();
        $uuid = '850186cc-9bac-44b8-a0f4-cea287290b8b';
        $request = $this->createMock(ApiRequestInterface::class);
        $request->method('getAttribute')->with('uuid', '')->willReturn($uuid);
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        // When & Then
        $storageApi->findOne();
    }
}
