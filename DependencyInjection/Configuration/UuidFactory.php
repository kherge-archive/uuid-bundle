<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Adds definitions for the `UuidFactory`.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class UuidFactory
{
    /**
     * Adds the definitions.
     *
     * @param NodeBuilder $node The node builder.
     */
    public function addDefinitions(NodeBuilder $node)
    {
        $node
            ->arrayNode('uuid_factory')
                ->info('The `UuidFactory` settings.')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('feature_set')
                        ->info('The feature set service to use for configuration.')
                        ->cannotBeEmpty()
                        ->defaultValue('kherge_uuid.feature_set')
                    ->end()
                    ->booleanNode('global')
                        ->info('Use this factory for `Uuid` static calls?')
                        ->cannotBeEmpty()
                        ->defaultFalse()
                        ->treatNullLike(false)
                    ->end()
                    ->scalarNode('number_converter')
                        ->info('The number conversion service to use.')
                        ->defaultValue('kherge_uuid.number_converter.degraded')
                    ->end()
                    ->scalarNode('random_generator')
                        ->info('The random byte generation service to use.')
                        ->defaultValue('kherge_uuid.generator.mt_rand')
                    ->end()
                    ->scalarNode('time_generator')
                        ->info('The time generation service to use.')
                        ->defaultValue('kherge_uuid.generator.default_time')
                    ->end()
                    ->scalarNode('uuid_builder')
                        ->info('The UUID building service to use.')
                        ->defaultValue('kherge_uuid.builder.default')
                    ->end()
        ;
    }
}
