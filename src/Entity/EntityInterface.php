<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Entity;

use Ifrost\ApiFoundation\Entity\ApiEntityInterface;
use Ifrost\EntityStorage\Entity\EntityInterface as StorageEntityInterface;

interface EntityInterface extends StorageEntityInterface, ApiEntityInterface
{
}
