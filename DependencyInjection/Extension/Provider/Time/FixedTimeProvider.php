<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Provider\Time;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `FixedTimeProvider` as a service.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class FixedTimeProvider extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.time_provider.fixed.class',
            'Ramsey\Uuid\Provider\Time\FixedTimeProvider'
        );

        $container->setDefinition(
            'kherge_uuid.time_provider.fixed',
            new Definition(
                '%kherge_uuid.time_provider.fixed.class%',
                [
                    $config['time_provider']['fixed']
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return !empty($config['time_provider']['fixed']);
    }
}
