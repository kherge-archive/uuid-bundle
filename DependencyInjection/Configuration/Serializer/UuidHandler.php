<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Serializer;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Adds definitions for registering the UUID handler with JMS serializer.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class UuidHandler
{
    /**
     * Adds the definitions.
     *
     * @param NodeBuilder $node The node builder.
     */
    public function addDefinitions(NodeBuilder $node)
    {
        $node
            ->booleanNode('uuid_handler')
                ->info('Enable the UUID serialization handler for JMS?')
                ->defaultTrue()
        ;
    }
}
