<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers `CombGenerator` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class CombGenerator extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.generator.comb.class',
            'Ramsey\Uuid\Generator\CombGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.generator.comb',
            new Definition(
                '%kherge_uuid.generator.comb.class%',
                [
                    new Reference($config['generator']['comb']['random_generator']),
                    new Reference($config['generator']['comb']['number_converter']),
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return !empty($config['generator']['comb']);
    }
}
