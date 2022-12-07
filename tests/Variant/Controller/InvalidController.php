<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Variant\Controller;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;
use Ifrost\StorageApiBundle\Tests\Variant\Sample;

#[StorageApi(entity: Product::class, storage: Sample::class)]
class InvalidController extends StorageApiControllerVariant
{
}
