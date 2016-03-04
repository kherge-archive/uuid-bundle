<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Builder;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers `DegradedUuidBuilder` as a service.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class DegradedUuidBuilder extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.builder.degraded.class',
            'Ramsey\Uuid\Builder\DegradedUuidBuilder'
        );

        $container->setDefinition(
            'kherge_uuid.builder.degraded',
            new Definition(
                '%kherge_uuid.builder.degraded.class%',
                [
                    new Reference($config['builder']['degraded']['number_converter'])
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return !empty($config['builder']['degraded']);
    }
}
