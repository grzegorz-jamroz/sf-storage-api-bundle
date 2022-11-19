<?php

declare(strict_types=1);

namespace Routing\StorageApiLoader;

use Ifrost\StorageApiBundle\Routing\AnnotatedRouteControllerLoader;
use Ifrost\StorageApiBundle\Routing\StorageApiLoader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;

class LoadTest extends TestCase
{
    public function testShouldReturnEmptyRouteCollectionWhenGivenPathPointsToASpecificFile()
    {
        // Given
        $path = sprintf('%s/tests/Variant/Controller/Game/PlayerController.php', ABSPATH);
        $loader = new StorageApiLoader(
            new FileLocator(),
            new AnnotatedRouteControllerLoader(),
        );

        // When
        $collection = $loader->load(
            $path,
            'storage_api_attribute'
        );

        // Then
        $this->assertCount(0, $collection);
    }

    public function testShouldReturnRouteCollectionWithTwelveRoutes()
    {
        // Given
        $path = sprintf('%s/tests/Variant/Controller/Game', ABSPATH);
        $loader = new StorageApiLoader(
            new FileLocator(),
            new AnnotatedRouteControllerLoader(),
        );

        // When
        $collection = $loader->load(
            $path,
            'storage_api_attribute'
        );

        // Then
        $this->assertCount(12, $collection);
    }
}
