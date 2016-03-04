<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Converter\Time;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `DegradedTimeConverter` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class DegradedTimeConverter extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.time_converter.degraded.class',
            'Ramsey\Uuid\Converter\Time\DegradedTimeConverter'
        );

        $container->setDefinition(
            'kherge_uuid.time_converter.degraded',
            new Definition('%kherge_uuid.time_converter.degraded.class%')
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
