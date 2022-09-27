<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Controller;

use Ifrost\ApiBundle\Controller\ApiController;
use Ifrost\StorageApiBundle\Utility\StorageApi;
use Ifrost\EntityStorage\Storage\EntityStorageInterface;

class StorageApiController extends ApiController
{
    protected function getStorageApi(string $entityClassName, EntityStorageInterface $storage): StorageApi
    {
        return new StorageApi($entityClassName, $storage, $this->getApiRequestService());
    }
}
