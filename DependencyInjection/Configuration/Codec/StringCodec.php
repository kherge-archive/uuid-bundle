<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Codec;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Adds definitions for the `StringCodec`.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class StringCodec
{
    /**
     * Adds the definitions.
     *
     * @param NodeBuilder $node The node builder.
     */
    public function addDefinitions(NodeBuilder $node)
    {
        $node
            ->arrayNode('string')
                ->info('The `StringCodec` settings.')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('uuid_builder')
                        ->info('The UUID builder service to use.')
                        ->cannotBeEmpty()
                        ->defaultValue('kherge_uuid.builder.default')
        ;
    }
}
