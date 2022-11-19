<?php

declare(strict_types=1);

namespace Tests\Unit\Utility\Action;

use Ifrost\StorageApiBundle\Utility\Action;
use PHPUnit\Framework\TestCase;

class FromValueTest extends TestCase
{
    public function testShouldThrowInvalidArgumentExceptionWhenValueDoesNotMatchAnyAction()
    {
        // Expect & Given
        $value = 'random';
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('There is no %s with value %s', Action::class, $value));

        // When & Then
        Action::fromValue($value);
    }
}
