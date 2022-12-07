<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\Controller\StorageApiController;

use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use Ifrost\ApiFoundation\ApiInterface;
use Ifrost\EntityStorage\Storage\EntityStorageInterface;
use Ifrost\StorageApiBundle\Collection\StorageCollection;
use Ifrost\StorageApiBundle\Entity\EntityInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Ifrost\StorageApiBundle\Tests\Variant\Controller\InvalidController;
use Ifrost\StorageApiBundle\Tests\Variant\Controller\ProductController;
use Ifrost\StorageApiBundle\Tests\Variant\Controller\StorageApiControllerVariant;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;
use Ifrost\StorageApiBundle\Tests\Variant\Sample;
use Ifrost\StorageApiBundle\Tests\Variant\Storage\ProductStorage;

class GetApiTest extends TestCase
{
    public function testShouldReturnStorageApiWhenEntityClassNameAndStoragePassedInMethodParameters()
    {
        // Given
        $controller = new StorageApiControllerVariant();
        $container = $this->createMock(Container::class);
        $apiRequest = $this->createMock(ApiRequestInterface::class);
        $container->method('get')->with('app.api_request')->willReturn($apiRequest);
        $controller->setContainer($container);
    
        // When & Then
        $this->assertInstanceOf(ApiInterface::class, $controller->getApi(Product::class, new ProductStorage()));
    }

    public function testShouldReturnStorageApiWhenEntityClassNameAndStoragePassedUsingStorageApiAttribute()
    {
        // Given
        $controller = new ProductController();
        $container = $this->createMock(Container::class);
        $apiRequest = $this->createMock(ApiRequestInterface::class);
        $container->method('get')
            ->withConsecutive(['ifrost_api.storage.collection'], ['app.api_request'])
            ->willReturnOnConsecutiveCalls(new StorageCollection([ProductStorage::class => new ProductStorage()]), $apiRequest);

        $controller->setContainer($container);

        // When & Then
        $this->assertInstanceOf(ApiInterface::class, $controller->getApi());
    }

    public function testShouldThrowInvalidArgumentExceptionWhenGivenEntityClassNameNotImplementsEntityInterface()
    {
        // Expect
        $entityClassName = Sample::class;
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Given argument entityClassName (%s) has to implement "%s" interface.', $entityClassName, EntityInterface::class));

        // Given
        $controller = new StorageApiControllerVariant();
        $container = $this->createMock(Container::class);
        $apiRequest = $this->createMock(ApiRequestInterface::class);
        $container->method('get')->with('app.api_request')->willReturn($apiRequest);
        $controller->setContainer($container);

        // When & Then
        $controller->getApi($entityClassName, new ProductStorage());
    }

    public function testShouldThrowInvalidArgumentExceptionWhenGivenProductStorageNotImplementsEntityStorageInterface()
    {
        // Expect
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Given argument "storage" (%s) has to implement "%s" interface.', Sample::class, EntityStorageInterface::class));

        // Given
        $controller = new InvalidController();
        $container = $this->createMock(Container::class);
        $apiRequest = $this->createMock(ApiRequestInterface::class);
        $container->method('get')
            ->withConsecutive(['ifrost_api.storage.collection'], ['app.api_request'])
            ->willReturnOnConsecutiveCalls(new StorageCollection([ProductStorage::class => new ProductStorage()]), $apiRequest);
        $controller->setContainer($container);

        // When & Then
        $controller->getApi();
    }
}
