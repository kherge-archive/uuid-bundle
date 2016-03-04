<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Provider\Node;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `RandomNodeProvider` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class RandomNodeProvider extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.node_provider.random.class',
            'Ramsey\Uuid\Provider\Node\RandomNodeProvider'
        );

        $container->setDefinition(
            'kherge_uuid.node_provider.random',
            new Definition('%kherge_uuid.node_provider.random.class%')
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
