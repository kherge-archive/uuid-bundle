<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Provider\Time;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `SystemTimeProvider` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class SystemTimeProvider extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.time_provider.system.class',
            'Ramsey\Uuid\Provider\Time\SystemTimeProvider'
        );

        $container->setDefinition(
            'kherge_uuid.time_provider.system',
            new Definition('%kherge_uuid.time_provider.system.class%')
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
