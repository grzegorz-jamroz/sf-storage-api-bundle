<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\Controller;

use Ifrost\ApiBundle\Utility\ApiRequest;
use Ifrost\StorageApiBundle\Utility\StorageApi;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Ifrost\StorageApiBundle\Tests\Unit\ProductTestCase;
use Ifrost\StorageApiBundle\Tests\Variant\Controller\ProductController;
use Ifrost\StorageApiBundle\Tests\Variant\Entity\Product;

class StorageApiControllerTestCase extends ProductTestCase
{
    protected Request $request;
    protected ProductController $controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new Request();
        $this->controller = new ProductController();
        $requestStack = new RequestStack();
        $requestStack->push($this->request);
        $api = new StorageApi(
            Product::class,
            $this->storage,
            new ApiRequest($requestStack)
        );
        $this->controller->setApi($api);
    }
}
