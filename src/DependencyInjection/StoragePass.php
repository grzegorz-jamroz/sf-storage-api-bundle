<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\DependencyInjection;

use Ifrost\EntityStorage\Storage\EntityStorageInterface;
use Ifrost\StorageApiBundle\Collection\StorageCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

class StoragePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->findDefinition(StorageCollection::class);
        $taggedServices = $container->findTaggedServiceIds('ifrost_api.storages');

        foreach ($taggedServices as $serviceId => $tags) {
            if (!is_subclass_of($serviceId, EntityStorageInterface::class)) {
                throw new RuntimeException(sprintf('Invalid storage "%s": class must implement %s.', $serviceId, EntityStorageInterface::class));
            }

            $definition->addMethodCall('set', [$serviceId, $container->findDefinition($serviceId)]);
        }
    }
}
