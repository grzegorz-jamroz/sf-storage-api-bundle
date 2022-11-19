<?php

declare(strict_types=1);

namespace Routing\StorageApiLoader;

use Ifrost\StorageApiBundle\Routing\AnnotatedRouteControllerLoader;
use Ifrost\StorageApiBundle\Routing\StorageApiLoader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;

class SupportsTest extends TestCase
{
    public function testShouldReturnTrueWhenSupportedTypeGiven()
    {
        // Given
        $type = 'storage_api_attribute';
        $loader = new StorageApiLoader(
            new FileLocator(),
            new AnnotatedRouteControllerLoader(),
        );

        // When & Then
        $this->assertTrue($loader->supports('', $type));
    }
}
