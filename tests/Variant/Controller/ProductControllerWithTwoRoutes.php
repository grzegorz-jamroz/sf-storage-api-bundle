<?php

declare(strict_types=1);

namespace Tests\Variant\Controller;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Ifrost\StorageApiBundle\Utility\Action;
use Tests\Variant\Entity\Product;
use Tests\Variant\Storage\ProductStorage;

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
