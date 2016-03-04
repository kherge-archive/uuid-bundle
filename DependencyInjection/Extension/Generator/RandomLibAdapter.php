<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers `RandomLibAdapter` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class RandomLibAdapter extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.generator.random_lib.class',
            'Ramsey\Uuid\Generator\RandomLibAdapter'
        );

        $container->setDefinition(
            'kherge_uuid.generator.random_lib',
            new Definition(
                '%kherge_uuid.generator.random_lib.class%',
                [
                    new Reference($config['generator']['random_lib']['generator'])
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return !empty($config['generator']['random_lib']);
    }
}
