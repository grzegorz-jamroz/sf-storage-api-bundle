<?php

declare(strict_types=1);

namespace Tests\Variant\Controller\Game;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Tests\Variant\Entity\Player;
use Tests\Variant\Storage\PlayerStorage;

#[StorageApi(entity: Player::class, storage: PlayerStorage::class, path: 'player')]
class PlayerController extends AbstractPlayerController
{
}
