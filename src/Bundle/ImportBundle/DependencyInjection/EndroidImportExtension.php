<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Bundle\ImportBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EndroidImportExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $taggedServices = $container->findTaggedServiceIds('endroid.import.importer');

        foreach ($taggedServices as $id => $tags) {
            $importerDefinition = $container->getDefinition($id);
            $importerDefinition->addMethodCall('setTimeLimit', [$config['time_limit']]);
            $importerDefinition->addMethodCall('setMemoryLimit', [$config['memory_limit']]);
        }
    }
}
