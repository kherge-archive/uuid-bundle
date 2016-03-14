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
        $root = $tree
            ->root('kherge_uuid')
            ->children()
        ;

        $this->register(
            $root
                ->arrayNode('builder')
                ->info('Settings for UUID builder services.')
                ->addDefaultsIfNotSet()
                ->children(),
            'Builder'
        );

        $this->register(
            $root
                ->arrayNode('codec')
                ->info('Settings for UUID encoding/decoding services.')
                ->addDefaultsIfNotSet()
                ->children(),
            'Codec'
        );

        $this->register(
            $root
                ->arrayNode('generator')
                ->info('Settings for random byte and time generation services.')
                ->addDefaultsIfNotSet()
                ->children(),
            'Generator'
        );

        $this->register(
            $root
                ->arrayNode('node_provider')
                ->info('Settings for node ID provider services.')
                ->children(),
            'Provider/Node'
        );

        $root
            ->booleanNode('param_converter')
                ->info('Enable support for UUID parameter conversion?')
                ->defaultTrue()
            ->end()
        ;

        $this->register(
            $root
                ->arrayNode('time_provider')
                ->info('Settings for time provider services.')
                ->children(),
            'Provider/Time'
        );

        $this->register($root, '');

        return $tree;
    }

    /**
     * Uses a directory of configuration definition classes to build the tree.
     *
     * @param NodeBuilder $node The node builder.
     * @param string      $dir  The name of the directory of classes.
     */
    private function register(NodeBuilder $node, $dir)
    {
        if (empty($dir)) {
            $path = __DIR__ . DIRECTORY_SEPARATOR . 'Configuration';
        } else {
            $path = sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'Configuration',
                DIRECTORY_SEPARATOR,
                $dir
            );
        }

        foreach (scandir($path) as $class) {
            $file = $path . DIRECTORY_SEPARATOR . $class;

            if (empty($dir)) {
                $class = sprintf(
                    '%s\Configuration\%s',
                    __NAMESPACE__,
                    explode('.', $class)[0]
                );
            } else {
                $class = sprintf(
                    '%s\Configuration\%s\%s',
                    __NAMESPACE__,
                    str_replace('/', '\\', $dir),
                    explode('.', $class)[0]
                );
            }

            if (is_file($file)) {
                $instance = new $class();
                $instance->addDefinitions($node);
            }
        }
    }
}
