<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Variant\Controller\Game;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Ifrost\StorageApiBundle\Controller\StorageApiController;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Monster;
use Ifrost\StorageApiBundle\Tests\Variant\Storage\MonsterStorage;

#[StorageApi(entity: Monster::class, storage: MonsterStorage::class, path: 'monster')]
class MonsterController extends StorageApiController
{
}
