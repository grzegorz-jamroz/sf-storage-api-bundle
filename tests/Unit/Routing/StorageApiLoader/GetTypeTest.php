<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\Routing\StorageApiLoader;

use Ifrost\StorageApiBundle\Tests\Variant\Routing\StorageApiLoaderVariant;
use PHPUnit\Framework\TestCase;

class GetTypeTest extends TestCase
{
    public function testShouldReturnDoctrineApiLoaderType()
    {
        // When & Then
        $this->assertEquals(
            'storage_api_attribute',
            (new StorageApiLoaderVariant())->getType()
        );
    }
}
