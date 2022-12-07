<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Variant\Controller\Game;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Player;
use Ifrost\StorageApiBundle\Tests\Variant\Storage\PlayerStorage;

#[StorageApi(entity: Player::class, storage: PlayerStorage::class, path: 'player')]
class PlayerController extends AbstractPlayerController
{
}
