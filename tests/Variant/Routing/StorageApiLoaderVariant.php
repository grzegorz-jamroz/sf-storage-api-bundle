<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Variant\Routing;

use Ifrost\StorageApiBundle\Routing\AnnotatedRouteControllerLoader;
use Ifrost\StorageApiBundle\Routing\StorageApiLoader;
use Symfony\Component\Config\FileLocator;

class StorageApiLoaderVariant extends StorageApiLoader
{
    public function __construct()
    {
        parent::__construct(new FileLocator(), new AnnotatedRouteControllerLoader());
    }

    public function getType(): string
    {
        return parent::getType();
    }
}
