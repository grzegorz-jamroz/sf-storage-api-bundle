<?php

declare(strict_types=1);

namespace Tests\Variant\Controller;

use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Tests\Variant\Entity\Product;
use Tests\Variant\Storage\ProductStorage;

#[StorageApi(entity: Product::class, storage: ProductStorage::class, path: 'products')]
class ProductControllerWithOverwrittenAction extends StorageApiControllerVariant
{
    #[Route('/create_products', name: 'products_create', methods: ['POST'])]
    public function create(): Response
    {
        return $this->getApi()->create();
    }
}
