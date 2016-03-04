<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Builder;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers `DefaultUuidBuilder` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class DefaultUuidBuilder extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.builder.default.class',
            'Ramsey\Uuid\Builder\DefaultUuidBuilder'
        );

        $container->setDefinition(
            'kherge_uuid.builder.default',
            new Definition(
                '%kherge_uuid.builder.default.class%',
                [
                    new Reference($config['builder']['default']['number_converter'])
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return !empty($config['builder']['default']);
    }
}
