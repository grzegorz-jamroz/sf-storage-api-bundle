<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\Utility\StorageApi;

use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use Ifrost\ApiFoundation\Exception\NotFoundException;
use Ifrost\StorageApiBundle\Utility\StorageApi;
use Ifrost\StorageApiBundle\Tests\Unit\ProductTestCase;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;

class ModifyTest extends ProductTestCase
{
    public function testShouldModifyOnlyRequestedFieldsForProduct(): void
    {
        // Expect & Given
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
                'code' => 'EBG34F321',
                'name' => 'Headphones',
            ]);
        $storageApi = new StorageApi(Product::class, $this->storage, $request);

        // When
        $storageApi->modify();

        // Then
        $this->assertEquals(
            [
                'uuid' => 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f',
                'code' => 'EBG34F321',
                'name' => 'Headphones',
                'description' => 'Shure',
            ],
            $this->storage->find($uuid)->jsonSerialize()
        );
    }

    public function testShouldThrowNotFoundExceptionWhenTryingToModifyProductWhichDoesNotExist()
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
        $storageApi->modify();
    }
}
