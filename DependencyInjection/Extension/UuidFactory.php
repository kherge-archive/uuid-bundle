<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers `UuidFactory` as a service.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class UuidFactory extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.uuid_factory.global',
            $config['uuid_factory']['global']
        );

        $container->setParameter(
            'kherge_uuid.uuid_factory.class',
            'Ramsey\Uuid\UuidFactory'
        );

        $definition = new Definition(
            '%kherge_uuid.uuid_factory.class%',
            [
                new Reference(
                    $config['uuid_factory']['feature_set'],
                    ContainerInterface::NULL_ON_INVALID_REFERENCE
                )
            ]
        );

        $setter = [
            'number_converter' => 'setNumberConverter',
            'random_generator' => 'setRandomGenerator',
            'time_generator' => 'setTimeGenerator',
            'uuid_builder' => 'setUuidBuilder'
        ];

        foreach ($setter as $parameter => $method) {
            if (isset($config['uuid_factory'][$parameter])) {
                $definition->addMethodCall(
                    $method,
                    [
                        new Reference($config['uuid_factory'][$parameter])
                    ]
                );
            }
        }

        $container->setDefinition('kherge_uuid.uuid_factory', $definition);
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return isset($config['uuid_factory']);
    }
}
