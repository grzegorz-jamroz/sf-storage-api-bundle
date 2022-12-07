<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\Controller\StorageApiController;

use Ifrost\ApiFoundation\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Ifrost\StorageApiBundle\Tests\Unit\Controller\StorageApiControllerTestCase;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;

class UpdateTest extends StorageApiControllerTestCase
{
    public function testShouldUpdateAllFieldsForRequestedProduct()
    {
        // Expect && Given
        $this->tempProductsDirectory->delete();
        $uuid = 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f';
        $this->storage->create(Product::createFromArray($this->productsData->get($uuid)));
        $this->request->attributes = new ParameterBag([
            'uuid' => $uuid,
        ]);
        $this->request->request = new ParameterBag([
            'code' => 'PDO79R564',
            'name' => 'accordion',
        ]);

        // When
        $response = $this->controller->update();

        // Then
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(
            new JsonResponse([
                'uuid' => 'f3e56592-0bfd-4669-be39-6ac8ab5ac55f',
                'code' => 'PDO79R564',
                'name' => 'accordion',
                'description' => '',
            ]),
            $response
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
        $this->request->attributes = new ParameterBag([
            'uuid' => $uuid,
        ]);
        $this->request->request = new ParameterBag([
            'name' => 'accordion',
        ]);

        // When & Then
        $this->controller->update();
    }
}
