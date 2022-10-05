<?php

declare(strict_types=1);

namespace Tests\Variant\Controller;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Tests\Variant\Entity\Product;
use Tests\Variant\Sample;

#[StorageApi(entity: Product::class, storage: Sample::class)]
class InvalidController extends StorageApiControllerVariant
{
}
