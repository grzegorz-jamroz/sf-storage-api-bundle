<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle;

use Ifrost\StorageApiBundle\DependencyInjection\StoragePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class IfrostStorageApiBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new StoragePass());
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
