<?php

declare(strict_types=1);

namespace Tests\Unit\IfrostStorageApiBundle;

use Ifrost\StorageApiBundle\IfrostStorageApiBundle;
use PHPUnit\Framework\TestCase;

class GetPathTest extends TestCase
{
    public function testShouldReturnPath()
    {
        // When & Then
        $this->assertEquals(ABSPATH, (new IfrostStorageApiBundle())->getPath());
    }
}
