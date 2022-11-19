<?php

declare(strict_types=1);

namespace Tests\Unit\Controller\StorageApiController;

use Ifrost\ApiFoundation\Exception\NotUniqueException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Tests\Unit\Controller\StorageApiControllerTestCase;
use Tests\Variant\Entity\Product;

class CreateTest extends StorageApiControllerTestCase
{
    public function testShouldCreateRequestedProduct()
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();
        $this->assertCount(0, $this->storage->findAll());
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $this->request->request = new ParameterBag($this->productsData->get($uuid));

        // When
        $response = $this->controller->create();

        // Then
        $products = $this->storage->findAll();
        $this->assertCount(1, $products);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(new JsonResponse($this->products->get($uuid)), $response);
    }

    public function testShouldThrowNotUniqueExceptionWhenTryingToCreateProductWhichHasNotUniqueUuid()
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $this->expectException(NotUniqueException::class);
        $this->expectExceptionMessage(sprintf('Unable to create "%s" due to not unique fields.', Product::class));
        $this->request->request = new ParameterBag($this->productsData->get($uuid));

        // When & Then
        $this->controller->create();
        $this->controller->create();
    }
}
