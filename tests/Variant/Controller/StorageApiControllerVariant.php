<?php

declare(strict_types=1);

namespace Tests\Variant\Controller;

use Ifrost\EntityStorage\Storage\EntityStorageInterface;
use Ifrost\StorageApiBundle\Controller\StorageApiController;
use Ifrost\StorageApiBundle\Utility\StorageApi;

class StorageApiControllerVariant extends StorageApiController
{
    public function getStorageApi(string $entityClassName, EntityStorageInterface $storage): StorageApi
    {
        return parent::getStorageApi($entityClassName, $storage);
    }
}
