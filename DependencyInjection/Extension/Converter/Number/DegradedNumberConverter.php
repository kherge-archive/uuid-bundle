<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Converter\Number;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `DegradedNumberConverter` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class DegradedNumberConverter extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.number_converter.degraded.class',
            'Ramsey\Uuid\Converter\Number\DegradedNumberConverter'
        );

        $container->setDefinition(
            'kherge_uuid.number_converter.degraded',
            new Definition('%kherge_uuid.number_converter.degraded.class%')
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
