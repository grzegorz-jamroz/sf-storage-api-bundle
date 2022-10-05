<?php

declare(strict_types=1);

namespace Tests\Variant\Controller;

use Ifrost\EntityStorage\Storage\EntityStorageInterface;
use Ifrost\StorageApiBundle\Collection\StorageCollection;
use Ifrost\StorageApiBundle\Controller\StorageApiController;
use Ifrost\StorageApiBundle\Utility\StorageApi;

class StorageApiControllerVariant extends StorageApiController
{
    public function getApi(
        string $entityClassName = '',
        ?EntityStorageInterface $storage = null
    ): StorageApi
    {
        return parent::getApi($entityClassName, $storage);
    }

    public function getStorages(): StorageCollection
    {
        return parent::getStorages();
    }
}
