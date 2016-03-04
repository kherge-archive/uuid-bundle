<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Generator;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Adds definitions for the `RandomLibGenerator`.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class RandomLibAdapter
{
    /**
     * Adds the definitions.
     *
     * @param NodeBuilder $node The node builder.
     */
    public function addDefinitions(NodeBuilder $node)
    {
        $node
            ->arrayNode('random_lib')
                ->info('The `RandomLibAdapter` settings.')
                ->children()
                    ->scalarNode('generator')
                        ->info('The `RandomLib` generator service to use.')
                        ->cannotBeEmpty()
        ;
    }
}
