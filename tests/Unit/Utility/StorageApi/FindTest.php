<?php

declare(strict_types=1);

namespace Tests\Unit\Utility\StorageApi;

use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use Ifrost\StorageApiBundle\Utility\StorageApi;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\Unit\ProductTestCase;
use Tests\Variant\Entity\Product;

class FindTest extends ProductTestCase
{
    public function testShouldReturnEmptyResponse(): void
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();
        $request = $this->createMock(ApiRequestInterface::class);
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        // When & Then
        $this->assertEquals(new JsonResponse([]), $storageApi->find());
    }

    public function testShouldReturnResponseWithOneProduct(): void
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();
        $uuid = '8b40a6d6-1a79-4edc-bfca-0f8d993c29f3';
        $this->storage->create($this->products->get($uuid));
        $request = $this->createMock(ApiRequestInterface::class);
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        // When & Then
        $this->assertEquals(new JsonResponse([$this->products->get($uuid)]), $storageApi->find());
    }

    public function testShouldReturnResponseWithFourProducts(): void
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();

        foreach ($this->products as $product) {
            $this->storage->create($product);
        }

        $request = $this->createMock(ApiRequestInterface::class);
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        // When
        $response = $storageApi->find();

        // Then
        $this->assertCount(4, json_decode($response->getContent(), true));
        $this->assertEquals(new JsonResponse($this->products->getValues()), $response);
    }
}
