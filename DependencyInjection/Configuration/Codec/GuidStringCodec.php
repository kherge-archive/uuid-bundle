<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Codec;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Adds definitions for the `GuidStringCodec`.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class GuidStringCodec
{
    /**
     * Adds the definitions.
     *
     * @param NodeBuilder $node The node builder.
     */
    public function addDefinitions(NodeBuilder $node)
    {
        $node
            ->arrayNode('guid')
                ->info('The `GuidStringCodec` settings.')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('uuid_builder')
                        ->info('The UUID builder service to use.')
                        ->cannotBeEmpty()
                        ->defaultValue('kherge_uuid.builder.default')
        ;
    }
}
