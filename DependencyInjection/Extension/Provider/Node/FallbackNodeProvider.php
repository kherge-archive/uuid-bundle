<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Provider\Node;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers `FallbackNodeProvider` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class FallbackNodeProvider extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.node_provider.fallback.class',
            'Ramsey\Uuid\Provider\Node\FallbackNodeProvider'
        );

        $references = [];

        foreach ($config['node_provider']['fallback'] as $id) {
            $references[] = new Reference($id);
        }

        $container->setDefinition(
            'kherge_uuid.node_provider.fallback',
            new Definition(
                '%kherge_uuid.node_provider.fallback.class%',
                [
                    $references
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return !empty($config['node_provider']['fallback']);
    }
}
