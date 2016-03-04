<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `MtRandGenerator` as a service.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class MtRandGenerator extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.generator.mt_rand.class',
            'Ramsey\Uuid\Generator\MtRandGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.generator.mt_rand',
            new Definition('%kherge_uuid.generator.mt_rand.class%')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return true;
    }
}
