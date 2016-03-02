<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Creates the definitions for the bundle configuration settings.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder();
        $root = $tree->root('kherge_uuid');

        $this->addFeatureSet($root->children());
        $this->addUuidFactory($root->children());

        return $tree;
    }

    /**
     * Adds the definitions for configuring the `FeatureSet` class.
     *
     * @param NodeBuilder $node The node bulider.
     */
    private function addFeatureSet(NodeBuilder $node)
    {
        $node
            ->arrayNode('feature_set')
                ->info('Settings for the `FeatureSet` class.')
                ->addDefaultsIfNotSet()
                ->children()
                    ->booleanNode('disable_big_number')
                        ->info('Disable the use of the BigNumber library?')
                        ->defaultFalse()
                    ->end()
                    ->booleanNode('disable_system_node')
                        ->info('Disable the use of the system node ID?')
                        ->defaultFalse()
                    ->end()
                    ->booleanNode('force_32bit')
                        ->info('Force 32-bit mode? (requires BigNumber library)')
                        ->defaultFalse()
                    ->end()
                    ->arrayNode('time_provider')
                        ->info('The service to use as the time provider.')
                        ->children()
                            ->scalarNode('id')
                                ->info('If not set, PECL or system will be used.')
                                ->cannotBeEmpty()
                                ->isRequired()
                            ->end()
                        ->end()
                    ->end()
                    ->booleanNode('use_guids')
                        ->info('Encode and decode Microsoft variant UUIDs?')
                        ->defaultFalse()
                    ->end()
                    ->booleanNode('use_pecl')
                        ->info('Use PECL extension to generate time-based UUIDs?')
                        ->defaultFalse()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Adds the definitions for configuring the `UuidFactory` class.
     *
     * @param NodeBuilder $node The node bulider.
     */
    private function addUuidFactory(NodeBuilder $node)
    {
        $node
            ->arrayNode('uuid_factory')
                ->info('Settings for the `UuidFactory` class.')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('feature_set')
                        ->info('The `FeatureSet` service to use.')
                        ->addDefaultsIfNotSet()
                        ->cannotBeEmpty()
                        ->children()
                            ->scalarNode('id')
                                ->cannotBeEmpty()
                                ->defaultValue('kherge_uuid.feature_set')
                                ->isRequired()
                            ->end()
                        ->end()
                    ->end()
                    ->booleanNode('global')
                        ->info('Set the factory singleton on `Uuid`?')
                        ->defaultFalse()
                    ->end()
                    ->arrayNode('number_converter')
                        ->info('The service to use as the number converter.')
                        ->children()
                            ->scalarNode('id')
                                ->defaultNull()
                                ->isRequired()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('random_generator')
                        ->info('The service to use as the random byte generator.')
                        ->children()
                            ->scalarNode('id')
                                ->defaultNull()
                                ->isRequired()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('time_generator')
                        ->info('The service to use as the time generator.')
                        ->children()
                            ->scalarNode('id')
                                ->defaultNull()
                                ->isRequired()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('uuid_builder')
                        ->info('The service to use as the UUID builder.')
                        ->children()
                            ->scalarNode('id')
                                ->defaultNull()
                                ->isRequired()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
