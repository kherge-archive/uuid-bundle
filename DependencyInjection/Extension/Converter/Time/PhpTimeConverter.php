<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Converter\Time;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `PhpTimeConverter` as a service.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class PhpTimeConverter extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.time_converter.php.class',
            'Ramsey\Uuid\Converter\Time\PhpTimeConverter'
        );

        $container->setDefinition(
            'kherge_uuid.time_converter.php',
            new Definition('%kherge_uuid.time_converter.php.class%')
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
