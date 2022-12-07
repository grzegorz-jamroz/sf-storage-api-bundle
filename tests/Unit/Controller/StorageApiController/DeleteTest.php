<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\Controller\StorageApiController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Ifrost\StorageApiBundle\Tests\Unit\Controller\StorageApiControllerTestCase;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;

class DeleteTest extends StorageApiControllerTestCase
{
    public function testShouldDeleteRequestedProduct(): void
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $this->storage->create(Product::createFromArray($this->productsData->get($uuid)));
        $this->assertCount(1, $this->storage->findAll());
        $this->request->attributes = new ParameterBag([
            'uuid' => $uuid,
        ]);

        // When
        $response = $this->controller->delete();

        // Then
        $this->assertCount(0, $this->storage->findAll());
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(new JsonResponse(), $response);
    }

    public function testShouldReturnEmptySuccessResponseWhenTryingToDeleteProductWhichDoesNotExist()
    {
        // Expect
        $this->tempProductsDirectory->delete();

        // Given
        $this->request->attributes = new ParameterBag([
            'uuid' => 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f',
        ]);

        // When
        $response = $this->controller->delete();

        // Then
        $this->assertCount(0, $this->storage->findAll());
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(new JsonResponse(), $response);
    }
}
