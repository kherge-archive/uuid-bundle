<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers `DefaultTimeGenerator` as a service.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class DefaultTimeGenerator extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.generator.default_time.class',
            'Ramsey\Uuid\Generator\DefaultTimeGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.generator.default_time',
            new Definition(
                '%kherge_uuid.generator.default_time.class%',
                [
                    new Reference($config['generator']['default_time']['node_provider']),
                    new Reference($config['generator']['default_time']['time_converter']),
                    new Reference($config['generator']['default_time']['time_provider']),
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return !empty($config['generator']['default_time']);
    }
}
