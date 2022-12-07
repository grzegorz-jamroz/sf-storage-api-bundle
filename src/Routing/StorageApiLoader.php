<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Routing;

use Ifrost\ApiFoundation\Routing\AbstractApiLoader;

class StorageApiLoader extends AbstractApiLoader
{
    protected function getType(): string
    {
        return 'storage_api_attribute';
    }
}
