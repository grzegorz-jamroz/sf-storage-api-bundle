<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Variant\Routing;

use Ifrost\StorageApiBundle\Routing\AnnotatedRouteControllerLoader;

class AnnotatedRouteControllerLoaderVariant extends AnnotatedRouteControllerLoader
{
    public function getAttributeClassName(): string
    {
        return parent::getAttributeClassName();
    }
}
