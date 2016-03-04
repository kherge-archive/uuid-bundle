<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `PeclUuidRandomGenerator` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class PeclUuidRandomGenerator extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.generator.pecl_uuid_random.class',
            'Ramsey\Uuid\Generator\PeclUuidRandomGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.generator.pecl_uuid_random',
            new Definition('%kherge_uuid.generator.pecl_uuid_random.class%')
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
