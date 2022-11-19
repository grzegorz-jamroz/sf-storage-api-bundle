<h1 align="center">Ifrost Storage Api Bundle for Symfony</h1>

<p align="center">
    <strong>Bundle provides basic features for Symfony Storage Api base on source files</strong>
</p>

<p align="center">
    <img src="https://img.shields.io/badge/php->=8.1-blue?colorB=%238892BF" alt="Code Coverage">  
    <img src="https://img.shields.io/badge/coverage-100%25-brightgreen" alt="Code Coverage">   
    <img src="https://img.shields.io/badge/release-v6.1.4-blue" alt="Release Version">   
</p>

## Installation

```
composer require grzegorz-jamroz/sf-storage-api-bundle
```

## Base Usage
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

2. Update routing configuration in your project:

```yaml
# config/routes.yaml
controllers:
    resource: ../src/Controller/
    type: attribute

# ...

# add those lines:
ifrost_storage_api_controllers:
    resource: ../src/Controller/
    type: storage_api_attribute
    
# ...
```

3. Create your controller:

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Storage\ProductStorage;
use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Ifrost\StorageApiBundle\Controller\StorageApiController;

#[StorageApi(entity: Product::class, storage: ProductStorage::class, path: 'products')]
class ProductController extends StorageApiController
{
}
```

4. Now you can debug your routes. Run command:

```
php bin/console debug:router
```

you should get output:

```
 ------------------- -------- -------- ------ -------------------------- 
  Name                Method   Scheme   Host   Path                      
 ------------------- -------- -------- ------ -------------------------- 
  _preview_error      ANY      ANY      ANY    /_error/{code}.{_format}  
  products_find       GET      ANY      ANY    /products                 
  products_find_one   GET      ANY      ANY    /products/{uuid}          
  products_create     POST     ANY      ANY    /products                 
  products_update     PUT      ANY      ANY    /products/{uuid}          
  products_modify     PATCH    ANY      ANY    /products/{uuid}          
  products_delete     DELETE   ANY      ANY    /products/{uuid}          
 ------------------- -------- -------- ------ -------------------------- 
```

## More custom usage

If you decided that you want to change routing configuration for some specific route just add `Route` attribute with new parameters. For example:

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

#[StorageApi(entity: Product::class, storage: ProductStorage::class, path: 'products')]
class ProductController extends StorageApiController
{
    #[Route('/create_products', name: 'products_create', methods: ['POST'])]
    public function create(): Response
    {
        return $this->getApi()->create();
    }
}
```

now output from `php bin/console debug:router` will be:

```
 ------------------- -------- -------- ------ -------------------------- 
  Name                Method   Scheme   Host   Path                      
 ------------------- -------- -------- ------ -------------------------- 
  _preview_error      ANY      ANY      ANY    /_error/{code}.{_format}  
  products_create     POST     ANY      ANY    /create_products          
  products_find       GET      ANY      ANY    /products                 
  products_find_one   GET      ANY      ANY    /products/{uuid}          
  products_update     PUT      ANY      ANY    /products/{uuid}          
  products_modify     PATCH    ANY      ANY    /products/{uuid}          
  products_delete     DELETE   ANY      ANY    /products/{uuid}          
 ------------------- -------- -------- ------ -------------------------- 
```

It is possible do disable some actions at all. In this case you can use `excludedActions` metadata.

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Storage\ProductStorage;
use Ifrost\StorageApiBundle\Attribute\StorageApi;
use Ifrost\StorageApiBundle\Controller\StorageApiController;
use Ifrost\StorageApiBundle\Utility\Action;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[StorageApi(
    entity: Product::class,
    storage: ProductStorage::class,
    path: 'products',
    excludedActions: [
        Action::CREATE,
        Action::UPDATE,
        Action::MODIFY,
        'delete',
        'not_valid_actions_will_be_omitted'
    ])]
class ProductController extends StorageApiController
{
}
```

now output from `php bin/console debug:router` will be:

```
 ------------------- -------- -------- ------ --------------------------
  Name                Method   Scheme   Host   Path
 ------------------- -------- -------- ------ --------------------------
  _preview_error      ANY      ANY      ANY    /_error/{code}.{_format}
  products_find       GET      ANY      ANY    /products
  products_find_one   GET      ANY      ANY    /products/{uuid}
 ------------------- -------- -------- ------ --------------------------
```
