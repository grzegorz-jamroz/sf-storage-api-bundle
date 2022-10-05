<?php

declare(strict_types=1);

namespace Tests\Unit\DependencyInjection\StoragePass;

use Ifrost\EntityStorage\Storage\EntityStorageInterface;
use Ifrost\StorageApiBundle\Collection\StorageCollection;
use Ifrost\StorageApiBundle\DependencyInjection\StoragePass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Tests\Variant\Sample;
use Tests\Variant\Storage\ProductStorage;
use Tests\Variant\Storage\VipProductStorage;

class ProcessTest extends TestCase
{
    public function testShouldReturnEmptyStorageCollection()
    {
        // Given
        $container = new ContainerBuilder();
        $container->setDefinition(StorageCollection::class, (new Definition())->setPublic(true));

        // When
        (new StoragePass())->process($container);
        $container->compile();

        // Then
        $this->assertCount(0, $container->get('Ifrost\StorageApiBundle\Collection\StorageCollection'));
    }

    public function testShouldProcessStoragesWhichImplementEntityStorageInterfaceAndReturnStorageCollectionWithOneStorage()
    {
        // Given
        $container = new ContainerBuilder();
        $container->setDefinition(StorageCollection::class, (new Definition())->setPublic(true));
        $container->setDefinition(ProductStorage::class, (new Definition())->addTag('ifrost_api.storages')->setPublic(true));

        // When
        (new StoragePass())->process($container);
        $container->compile();

        // Then
        $this->assertCount(1, $container->get('Ifrost\StorageApiBundle\Collection\StorageCollection'));
    }

    public function testShouldProcessStoragesWhichImplementEntityStorageInterfaceAndReturnStorageCollectionWithTwoStorages()
    {
        // Given
        $container = new ContainerBuilder();
        $container->setDefinition(StorageCollection::class, (new Definition())->setPublic(true));
        $container->setDefinition(ProductStorage::class, (new Definition())->addTag('ifrost_api.storages')->setPublic(true));
        $container->setDefinition(VipProductStorage::class, (new Definition())->addTag('ifrost_api.storages')->setPublic(true));

        // When
        (new StoragePass())->process($container);
        $container->compile();

        // Then
        $this->assertCount(2, $container->get('Ifrost\StorageApiBundle\Collection\StorageCollection'));
    }

    public function testShouldThrowRuntimeExceptionWhenTaggedServiceNotImplementsEntityStorageInterface()
    {
        // Expect
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(sprintf('Invalid storage "%s": class must implement %s.', Sample::class, EntityStorageInterface::class));

        // Given
        $container = new ContainerBuilder();
        $container->setDefinition(StorageCollection::class, (new Definition())->setPublic(true));
        $container->setDefinition(Sample::class, (new Definition())->addTag('ifrost_api.storages')->setPublic(true));

        // When & Then
        (new StoragePass())->process($container);
        $container->compile();
    }
}
