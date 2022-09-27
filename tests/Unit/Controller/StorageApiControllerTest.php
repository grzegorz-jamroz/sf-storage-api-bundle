<?php

declare(strict_types=1);

namespace Tests\Unit\Controller;

use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use Ifrost\EntityStorage\Entity\EntityInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Tests\Variant\Controller\StorageApiControllerVariant;
use Tests\Variant\Sample;
use Tests\Variant\Storage\ProductStorage;

class StorageApiControllerTest extends TestCase
{
    public function testShouldThrowInvalidArgumentExceptionWhenEntityClassNameIsNotInstanceOfEntityInterface(): void
    {
        // Expect && Given
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Given argument entityClassName (%s) has to implement "%s" interface.', Sample::class, EntityInterface::class));
        $controller = new StorageApiControllerVariant();
        $container = $this->createMock(Container::class);
        $apiRequest = $this->createMock(ApiRequestInterface::class);
        $container->method('get')->with('app.api_request')->willReturn($apiRequest);
        $controller->setContainer($container);

        // When & Then
        $controller->getStorageApi(Sample::class, new ProductStorage())->findOne();
    }
}
