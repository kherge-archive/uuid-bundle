<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Provider\Node;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `SystemNodeProvider` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class SystemNodeProvider extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.node_provider.system.class',
            'Ramsey\Uuid\Provider\Node\SystemNodeProvider'
        );

        $container->setDefinition(
            'kherge_uuid.node_provider.system',
            new Definition('%kherge_uuid.node_provider.system.class%')
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
