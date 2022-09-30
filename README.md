<h1 align="center">Ifrost Storage Api Bundle for Symfony</h1>

<p align="center">
    <strong>Bundle provides basic features for Symfony Storage Api base on source files</strong>
</p>

<p align="center">
    <img src="https://img.shields.io/badge/php->=8.1-blue?colorB=%238892BF" alt="Code Coverage">  
    <img src="https://img.shields.io/badge/coverage-100%25-brightgreen" alt="Code Coverage">   
    <img src="https://img.shields.io/badge/release-v6.1.1-blue" alt="Release Version">   
</p>

## Installation

```
composer require grzegorz-jamroz/sf-storage-api-bundle
```

## Usage
1. Tag storages - for example:

```yaml
# config/services.yaml
services:

  # ...
  
  _instanceof:
    # services whose classes are instances of EntityStorageInterface will be tagged automatically
    Ifrost\EntityStorage\Storage\EntityStorageInterface:
      tags: [ifrost_api.storages]

  # ...
```

2. Create your controller:

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Storage\ProductStorage;
use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Ifrost\StorageApiBundle\Controller\StorageApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[StorageApi(entity: Product::class, storage: ProductStorage::class)]
class ProductController extends StorageApiController
{
    #[Route('/products', name: 'products_find', methods: ['GET'])]
    public function find(): Response
    {
        return $this->getApi()->find();
    }

    #[Route('/products/{uuid}', name: 'products_find_one', methods: ['GET'])]
    public function findOne(): Response
    {
        return $this->getApi()->findOne();
    }

    #[Route('/products', name: 'products_create', methods: ['POST'])]
    public function create(): Response
    {
        return $this->getApi()->create();
    }

    #[Route('/products/{uuid}', name: 'products_update', methods: ['PUT'])]
    public function update(): Response
    {
        return $this->getApi()->update();
    }

    #[Route('/products/{uuid}', name: 'products_modify', methods: ['PATCH'])]
    public function modify(): Response
    {
        return $this->getApi()->modify();
    }

    #[Route('/products/{uuid}', name: 'products_delete', methods: ['DELETE'])]
    public function delete(): Response
    {
        return $this->getApi()->delete();
    }
}
```
