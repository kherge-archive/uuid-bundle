<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Converter\Time;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `BigNumberTimeConverter` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class BigNumberTimeConverter extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.time_converter.big_number.class',
            'Ramsey\Uuid\Converter\Time\BigNumberTimeConverter'
        );

        $container->setDefinition(
            'kherge_uuid.time_converter.big_number',
            new Definition('%kherge_uuid.time_converter.big_number.class%')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return class_exists('Moontoast\Math\BigNumber');
    }
}
