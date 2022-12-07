<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\DependencyInjection\IfrostStorageApiExtension;

use Ifrost\StorageApiBundle\DependencyInjection\IfrostStorageApiExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LoadTest extends TestCase
{
    public function testShouldLoadConfigurationFromFile()
    {
        // Given
        $container = new ContainerBuilder();

        // When
        (new IfrostStorageApiExtension())->load([], $container);

        // Then
        $this->assertNotNull($container->getDefinition('Ifrost\StorageApiBundle\Collection\StorageCollection'));
    }
}
