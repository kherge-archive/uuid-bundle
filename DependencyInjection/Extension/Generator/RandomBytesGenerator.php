<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `RandomBytesGenerator` as a service.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class RandomBytesGenerator extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.generator.random_bytes.class',
            'Ramsey\Uuid\Generator\RandomBytesGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.generator.random_bytes',
            new Definition('%kherge_uuid.generator.random_bytes.class%')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return function_exists('random_bytes');
    }
}
