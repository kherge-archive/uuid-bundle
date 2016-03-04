<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Builder;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Adds definitions for the `DegradedUuidBulider`.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class DegradedUuidBuilder
{
    /**
     * Adds the definitions.
     *
     * @param NodeBuilder $node The node builder.
     */
    public function addDefinitions(NodeBuilder $node)
    {
        $node
            ->arrayNode('degraded')
                ->info('The `DegradedUuidBuilder` settings.')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('number_converter')
                        ->info('The number conversion service to use.')
                        ->cannotBeEmpty()
                        ->defaultValue('kherge_uuid.number_converter.degraded')
        ;
    }
}
