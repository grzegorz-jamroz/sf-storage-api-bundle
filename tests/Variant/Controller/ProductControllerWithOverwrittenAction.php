<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Variant\Controller;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;
use Ifrost\StorageApiBundle\Tests\Variant\Storage\ProductStorage;

#[StorageApi(entity: Product::class, storage: ProductStorage::class, path: 'products')]
class ProductControllerWithOverwrittenAction extends StorageApiControllerVariant
{
    #[Route('/create_products', name: 'products_create', methods: ['POST'])]
    public function create(): Response
    {
        return $this->getApi()->create();
    }
}
