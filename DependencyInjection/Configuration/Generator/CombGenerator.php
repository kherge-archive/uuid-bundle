<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Generator;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Adds definitions for the `CombGenerator`.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class CombGenerator
{
    /**
     * Adds the definitions.
     *
     * @param NodeBuilder $node The node builder.
     */
    public function addDefinitions(NodeBuilder $node)
    {
        $node
            ->arrayNode('comb')
                ->info('The `CombGenerator` settings.')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('random_generator')
                        ->info('The random byte generator service to use.')
                        ->cannotBeEmpty()
                        ->defaultValue('kherge_uuid.generator.mt_rand')
                    ->end()
                    ->scalarNode('number_converter')
                        ->info('The number version service to use.')
                        ->cannotBeEmpty()
                        ->defaultValue('kherge_uuid.number_converter.degraded')
        ;
    }
}
