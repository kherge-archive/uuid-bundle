<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Provider\Node;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Adds definitions for the `FallbackNodeProvider`.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class FallbackNodeProvider
{
    /**
     * Adds the definitions.
     *
     * @param NodeBuilder $node The node builder.
     */
    public function addDefinitions(NodeBuilder $node)
    {
        $node
            ->arrayNode('fallback')
                ->info('The list of node ID provider services for `FallbackNodeProvider`.')
                ->prototype('scalar')
                    ->cannotBeEmpty()
                    ->isRequired()
        ;
    }
}
