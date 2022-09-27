<?php

declare(strict_types=1);

namespace Tests\Unit\Utility\StorageApi;

use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use Ifrost\ApiFoundation\Exception\NotFoundException;
use Ifrost\StorageApiBundle\Utility\StorageApi;
use Tests\Unit\ProductTestCase;
use Tests\Variant\Entity\Product;

class UpdateTest extends ProductTestCase
{
    public function testShouldUpdateAllFieldsForRequestedProduct()
    {
        // Expect && Given
        $this->tempProductsDirectory->delete();
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $this->storage->create(Product::createFromArray($this->productsData->get($uuid)));
        $request = $this->createMock(ApiRequestInterface::class);
        $request->method('getAttribute')
            ->with('uuid', '')
            ->willReturn($uuid);
        $request->method('getRequest')
            ->with(Product::getFields())
            ->willReturn([
                'code' => 'PDO79R564',
                'name' => 'accordion',
            ]);
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        // When
        $storageApi->update();

        // Then
        $this->assertEquals(
            [
                'uuid' => 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f',
                'code' => 'PDO79R564',
                'name' => 'accordion',
                'description' => '',
            ],
            $this->storage->find($uuid)->jsonSerialize()
        );
    }

    public function testShouldThrowNotFoundExceptionWhenTryingToUpdateProductWhichDoesNotExist()
    {
        // Expect
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(sprintf('Record "%s" not found', Product::class));
        $this->tempProductsDirectory->delete();

        // Given
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $request = $this->createMock(ApiRequestInterface::class);
        $request->method('getAttribute')
            ->with('uuid', '')
            ->willReturn($uuid);
        $request->method('getRequest')
            ->with(Product::getFields())
            ->willReturn([
                'name' => 'accordion',
            ]);
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        // When & Then
        $storageApi->update();
    }

}
