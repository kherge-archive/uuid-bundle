<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers `FeatureSet` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class FeatureSet extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.feature_set.class',
            'Ramsey\Uuid\FeatureSet'
        );

        $definition = new Definition(
            '%kherge_uuid.feature_set.class%',
            [
                $config['feature_set']['use_guids'],
                $config['feature_set']['force_32bit'],
                $config['feature_set']['disable_big_number'],
                $config['feature_set']['disable_system_node'],
                $config['feature_set']['use_pecl']
            ]
        );

        if (isset($config['feature_set']['time_provider'])) {
            $definition->addMethodCall(
                'setTimeProvider',
                [
                    new Reference($config['feature_set']['time_provider'])
                ]
            );
        }

        $container->setDefinition('kherge_uuid.feature_set', $definition);
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return isset($config['feature_set']);
    }
}
