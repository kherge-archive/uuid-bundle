<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Serializer;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `UuidHandler` as a service.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class UuidHandler extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.serializer.uuid_handler.class',
            'KHerGe\Bundle\UuidBundle\Serializer\UuidHandler'
        );

        $definition = new Definition('%kherge_uuid.serializer.uuid_handler.class%');
        $definition->addTag('jms_serializer.subscribing_handler');

        $container->setDefinition(
            'kherge_uuid.serializer.uuid_handler',
            $definition
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return $config['serializer']['uuid_handler'];
    }
}
