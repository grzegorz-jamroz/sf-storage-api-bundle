<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\Controller\StorageApiController;

use Ifrost\StorageApiBundle\Collection\StorageCollection;
use Ifrost\StorageApiBundle\Controller\StorageApiController as Controller;
use PHPUnit\Framework\TestCase;

class GetStoragesTest extends TestCase
{
    public function testShouldReturnStorageCollection(): void
    {
        // Given
        $services = Controller::getSubscribedServices();

        // When & Then
        $this->assertEquals($services['ifrost_api.storage.collection'], sprintf('?%s', StorageCollection::class));
    }
}
