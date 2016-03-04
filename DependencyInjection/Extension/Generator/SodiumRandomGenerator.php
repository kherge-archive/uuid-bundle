<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `SodiumRandomGenerator` as a service.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class SodiumRandomGenerator extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.generator.sodium.class',
            'Ramsey\Uuid\Generator\SodiumRandomGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.generator.sodium',
            new Definition('%kherge_uuid.generator.sodium.class%')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return function_exists('Sodium\randombytes_buf');
    }
}
