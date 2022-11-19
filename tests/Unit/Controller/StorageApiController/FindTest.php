<?php

declare(strict_types=1);

namespace Tests\Unit\Controller\StorageApiController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\Unit\Controller\StorageApiControllerTestCase;

class FindTest extends StorageApiControllerTestCase
{
    public function testShouldReturnEmptyResponse()
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();
        $response = $this->controller->find();

        // Then
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(new JsonResponse([]), $response);
    }

    public function testShouldReturnResponseWithOneProduct()
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();
        $uuid = '8b40a6d6-1a79-4edc-bfca-0f8d993c29f3';
        $this->storage->create($this->products->get($uuid));

        // When
        $response = $this->controller->find();

        // Then
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(new JsonResponse([$this->products->get($uuid)]), $response);
    }

    public function testShouldReturnResponseWithFourPoducts()
    {
        // Expect & Given
        $this->tempProductsDirectory->delete();

        foreach ($this->products as $product) {
            $this->storage->create($product);
        }

        // When
        $response = $this->controller->find();

        // Then
        $this->assertInstanceOf(Response::class, $response);
        $this->assertCount(4, json_decode($response->getContent(), true));
        $this->assertEquals(new JsonResponse($this->products->getValues()), $response);
    }
}
