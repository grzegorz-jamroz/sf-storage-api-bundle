<?php
declare(strict_types=1);

namespace Tests\Unit\Controller\StorageApiController;

use Doctrine\Common\Collections\ArrayCollection;
use Ifrost\StorageApiBundle\Collection\StorageCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Tests\Variant\Controller\StorageApiControllerVariant;

class GetSubscribedServicesTest extends TestCase
{
    public function testShouldReturnStorageCollection(): void
    {
        // Given
        $controller = new StorageApiControllerVariant();
        $container = $this->createMock(Container::class);
        $container->method('get')->with('ifrost_api.storage.collection')->willReturn(new StorageCollection());
        $controller->setContainer($container);

        // When & Then
        $this->assertInstanceOf(StorageCollection::class, $controller->getStorages());
    }

    public function testShouldThrowRuntimeExceptionWhenCollectionIsNotInstanceOfStorageCollection()
    {
        // Expect
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(sprintf('Container identifier "ifrost_api.storage.collection" is not instance of %s', StorageCollection::class));

        // Given
        $controller = new StorageApiControllerVariant();
        $container = $this->createMock(Container::class);
        $container->method('get')->with('ifrost_api.storage.collection')->willReturn(new ArrayCollection());
        $controller->setContainer($container);

        // When & Then
        $controller->getStorages();
    }
}
