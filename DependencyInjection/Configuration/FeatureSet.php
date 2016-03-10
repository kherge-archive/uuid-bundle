<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Adds definitions for the `FeatureSet`.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class FeatureSet
{
    /**
     * Adds the definitions.
     *
     * @param NodeBuilder $node The node builder.
     */
    public function addDefinitions(NodeBuilder $node)
    {
        $node
            ->arrayNode('feature_set')
                ->info('The `FeatureSet` settings.')
                ->addDefaultsIfNotSet()
                ->children()
                    ->booleanNode('disable_big_number')
                        ->info('Disable use of the `BigNumber` library?')
                        ->defaultFalse()
                        ->treatNullLike(false)
                    ->end()
                    ->booleanNode('disable_system_node')
                        ->info('Disable the use of the system node ID provider?')
                        ->defaultFalse()
                        ->treatNullLike(false)
                    ->end()
                    ->booleanNode('force_32bit')
                        ->info('Force 32-bit mode even on a 64-bit system?')
                        ->defaultFalse()
                        ->treatNullLike(false)
                    ->end()
                    ->booleanNode('time_provider')
                        ->info('The time provider service to use.')
                        ->defaultValue('kherge_uuid.time_provider.system')
                    ->end()
                    ->booleanNode('use_guids')
                        ->info('Use Microsoft variant UUIDs?')
                        ->defaultFalse()
                        ->treatNullLike(false)
                    ->end()
                    ->booleanNode('use_pecl')
                        ->info('Use `uuid` PECL extension for time-based UUID generation?')
                        ->defaultFalse()
                        ->treatNullLike(false)
                    ->end()
        ;
    }
}
