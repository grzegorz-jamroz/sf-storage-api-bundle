<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\Controller\StorageApiController;

use Ifrost\ApiFoundation\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Ifrost\StorageApiBundle\Tests\Unit\Controller\StorageApiControllerTestCase;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;

class FindOneTest extends StorageApiControllerTestCase
{
    public function testShouldReturnResponseWithRequestedProduct()
    {
        // Expect
        $this->tempProductsDirectory->delete();

        foreach ($this->productsData as $productData) {
            $this->storage->create(Product::createFromArray($productData));
        }

        $this->assertCount(4, $this->storage->findAll());

        // Given
        $uuid = '8b40a6d6-1a79-4edc-bfca-0f8d993c29f3';
        $this->request->attributes = new ParameterBag([
            'uuid' => $uuid,
        ]);

        // When
        $response = $this->controller->findOne();

        // Then
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(new JsonResponse($this->products->get($uuid)), $response);
    }

    public function testShouldThrowNotFoundExceptionWhenRequestedProductDoesNotExist()
    {
        // Expect
        $this->tempProductsDirectory->delete();
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(sprintf('Record "%s" not found', Product::class));

        // Given
        $uuid = '850186cc-9bac-44b8-a0f4-cea287290b8b';
        $this->request->attributes = new ParameterBag([
            'uuid' => $uuid,
        ]);

        // When & Then
        $this->controller->findOne();
    }
}
