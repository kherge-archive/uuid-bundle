<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Generator;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Adds definitions for the `DefaultTimeGenerator`.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class DefaultTimeGenerator
{
    /**
     * Adds the definitions.
     *
     * @param NodeBuilder $node The node builder.
     */
    public function addDefinitions(NodeBuilder $node)
    {
        $node
            ->arrayNode('default_time')
                ->info('The `DefaultTimeGenerator` settings.')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('node_provider')
                        ->info('The node ID provider service to use.')
                        ->cannotBeEmpty()
                        ->defaultValue('kherge_uuid.node_provider.system')
                    ->end()
                    ->scalarNode('time_converter')
                        ->info('The time conversion service to use.')
                        ->cannotBeEmpty()
                        ->defaultValue('kherge_uuid.time_converter.degraded')
                    ->end()
                    ->scalarNode('time_provider')
                        ->info('The provider service to use.')
                        ->cannotBeEmpty()
                        ->defaultValue('kherge_uuid.time_provider.system')
        ;
    }
}
