<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Variant\Controller;

use Ifrost\ApiFoundation\ApiInterface;
use Ifrost\EntityStorage\Storage\EntityStorageInterface;
use Ifrost\StorageApiBundle\Collection\StorageCollection;
use Ifrost\StorageApiBundle\Controller\StorageApiController;
use Ifrost\StorageApiBundle\Utility\StorageApi;

class StorageApiControllerVariant extends StorageApiController
{
    private ApiInterface $api;

    public function getApi(
        string $entityClassName = '',
        ?EntityStorageInterface $storage = null
    ): StorageApi
    {
        return $this->api ?? parent::getApi($entityClassName, $storage);
    }

    public function getStorages(): StorageCollection
    {
        return parent::getStorages();
    }

    public function setApi(ApiInterface $api): void
    {
        $this->api = $api;
    }
}
