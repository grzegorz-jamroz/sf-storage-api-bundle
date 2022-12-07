<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Variant\Controller;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Ifrost\StorageApiBundle\Utility\Action;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;
use Ifrost\StorageApiBundle\Tests\Variant\Storage\ProductStorage;

#[StorageApi(
    entity: Product::class,
    storage: ProductStorage::class,
    path: 'products',
    excludedActions: [
        Action::CREATE,
        Action::UPDATE,
        Action::MODIFY,
        'delete',
    ])
]
class ProductControllerWithTwoRoutes extends StorageApiControllerVariant
{
}
