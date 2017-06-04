<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Import\Bundle\ImportBundle\DependencyInjection\Compiler;

use Endroid\Import\Command\ImportCommand;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ImporterCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('endroid.import.importer');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $name = $attributes['alias'];
                $commandDefinition = new Definition(ImportCommand::class, ['endroid:import:'.$name, new Reference($id)]);
                $commandDefinition->addTag('console.command');
                $container->setDefinition('endroid_import.command.'.$name, $commandDefinition);
                $container->setAlias('endroid_import.importer.'.$name, $id);
            }
        }
    }
}
