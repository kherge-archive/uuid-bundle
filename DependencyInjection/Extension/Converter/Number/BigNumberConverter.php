<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Converter\Number;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `BigNumberConverter` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class BigNumberConverter extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.number_converter.big_number.class',
            'Ramsey\Uuid\Converter\Number\BigNumberConverter'
        );

        $container->setDefinition(
            'kherge_uuid.number_converter.big_number',
            new Definition('%kherge_uuid.number_converter.big_number.class%')
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
