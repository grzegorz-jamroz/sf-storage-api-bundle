<?php

declare(strict_types=1);

namespace Tests\Unit\Utility\StorageApi;

use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use Ifrost\StorageApiBundle\Utility\StorageApi;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\Unit\ProductTestCase;
use Tests\Variant\Entity\Product;

class DeleteTest extends ProductTestCase
{
    public function testShouldDeleteRequestedProduct(): void
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $this->storage->create(Product::createFromArray($this->productsData->get($uuid)));
        $this->assertCount(1, $this->storage->findAll());
        $request = $this->createMock(ApiRequestInterface::class);
        $request->method('getAttribute')
            ->with('uuid', '')
            ->willReturn($uuid);
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        // When
        $storageApi->delete();

        // Then
        $this->assertCount(0, $this->storage->findAll());
    }

    public function testShouldReturnEmptySuccessResponseWhenTryingToDeleteProductWhichDoesNotExist()
    {
        // Expect
        $this->tempProductsDirectory->delete();

        // Given
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $request = $this->createMock(ApiRequestInterface::class);
        $request->method('getAttribute')
            ->with('uuid', '')
            ->willReturn($uuid);
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        // When & Then
        $this->assertEquals(new JsonResponse(), $storageApi->delete());
    }
}
