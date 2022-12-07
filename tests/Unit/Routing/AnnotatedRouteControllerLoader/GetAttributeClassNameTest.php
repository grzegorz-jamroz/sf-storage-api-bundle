<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\Routing\AnnotatedRouteControllerLoader;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Ifrost\StorageApiBundle\Tests\Variant\Routing\AnnotatedRouteControllerLoaderVariant;
use PHPUnit\Framework\TestCase;

class GetAttributeClassNameTest extends TestCase
{
    public function testShouldReturnApiAttributeClassName()
    {
        // When & Then
        $this->assertEquals(
            StorageApi::class,
            (new AnnotatedRouteControllerLoaderVariant())->getAttributeClassName()
        );
    }
}
