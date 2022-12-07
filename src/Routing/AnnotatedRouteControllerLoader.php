<?php

namespace Ifrost\StorageApiBundle\Routing;

use Ifrost\StorageApiBundle\Attribute\StorageApi as StorageApiAttribute;
use Ifrost\ApiFoundation\Routing\AbstractAnnotatedRouteControllerLoader;

class AnnotatedRouteControllerLoader extends AbstractAnnotatedRouteControllerLoader
{
    protected function getAttributeClassName(): string
    {
        return StorageApiAttribute::class;
    }
}
