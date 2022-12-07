<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Tests\Unit\IfrostStorageApiBundle;

use Ifrost\StorageApiBundle\Collection\StorageCollection;
use Ifrost\StorageApiBundle\DependencyInjection\StoragePass;
use Ifrost\StorageApiBundle\IfrostStorageApiBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class BuildTest extends TestCase
{
    public function testShouldAddStoragePassToCompilerPass()
    {
        // Given
        $container = new ContainerBuilder();
        $container->setDefinition(StorageCollection::class, (new Definition())->setPublic(true));
        $bundle = new IfrostStorageApiBundle();

        // When
        $bundle->build($container);
        $compiler = $container->getCompiler();

        // Then
        $this->assertCount(
            1,
            array_filter(
                $compiler->getPassConfig()->getBeforeOptimizationPasses(),
                fn (CompilerPassInterface $compilerPass) => $compilerPass instanceof StoragePass
            )
        );
    }
}
