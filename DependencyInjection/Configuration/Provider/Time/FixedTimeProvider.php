<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Provider\Time;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Adds definitions for the `FixedTimeProvider`.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class FixedTimeProvider
{
    /**
     * Adds the definitions.
     *
     * @param NodeBuilder $node The node builder.
     */
    public function addDefinitions(NodeBuilder $node)
    {
        $node
            ->arrayNode('fixed')
                ->info('The `FixedTimeProvider` settings.')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('sec')
                        ->info('The fixed number of seconds since the Unix Epoch.')
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('usec')
                        ->info('The fixed number of microseconds.')
                        ->cannotBeEmpty()
        ;
    }
}
