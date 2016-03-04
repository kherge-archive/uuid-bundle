<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `PeclUuidTimeGenerator` as a service.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class PeclUuidTimeGenerator extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.generator.pecl_uuid_time.class',
            'Ramsey\Uuid\Generator\PeclUuidTimeGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.generator.pecl_uuid_time',
            new Definition('%kherge_uuid.generator.pecl_uuid_time.class%')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return function_exists('uuid_create') && function_exists('uuid_parse');
    }
}
