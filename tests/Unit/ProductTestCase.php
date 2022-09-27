<?php

declare(strict_types=1);

namespace Tests\Unit;

use Doctrine\Common\Collections\ArrayCollection;
use Ifrost\Filesystem\Directory;
use Ifrost\Filesystem\JsonFile;
use PHPUnit\Framework\TestCase;
use Tests\Variant\Entity\Product;
use Tests\Variant\Storage\ProductStorage;

class ProductTestCase extends TestCase
{
    protected ProductStorage $storage;
    protected ArrayCollection $productsData;
    protected ArrayCollection $products;
    protected Directory $tempProductsDirectory;

    protected function setUp(): void
    {
        $this->tempProductsDirectory = new Directory(sprintf('%s/products', TEMPORARY_DATA_DIRECTORY));
        $this->storage = new ProductStorage();
        $testDirectoryPath = sprintf('%s/products', TESTS_DATA_DIRECTORY);
        $productUuids = [
            '62d925ad-4ef7-47a9-be28-79d71534c099',
            '8b40a6d6-1a79-4edc-bfca-0f8d993c29f3',
            'f3e56592-0bfd-4669-be39-6ac8ab5ac55f',
            'fe687d4a-a5fc-426b-ba15-13901bda54a6',
        ];
        $this->productsData = array_reduce(
            $productUuids,
            function (ArrayCollection $acc, string $uuid) use ($testDirectoryPath) {
                $acc->set($uuid, (new JsonFile(sprintf('%s/%s.json', $testDirectoryPath, $uuid)))->read());

                return $acc;
            },
            new ArrayCollection()
        );
        $this->products = array_reduce(
            $this->productsData->toArray(),
            function (ArrayCollection $acc, array $productData) {
                $acc->set($productData['uuid'], Product::createFromArray($productData));

                return $acc;
            },
            new ArrayCollection()
        );
        parent::setUp();
    }
}
