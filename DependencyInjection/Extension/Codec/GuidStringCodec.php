<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Codec;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers `GuidStringCodec` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class GuidStringCodec extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.codec.guid.class',
            'Ramsey\Uuid\Codec\GuidStringCodec'
        );

        $container->setDefinition(
            'kherge_uuid.codec.guid',
            new Definition(
                '%kherge_uuid.codec.guid.class%',
                [
                    new Reference($config['codec']['guid']['uuid_builder'])
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return !empty($config['codec']['guid']);
    }
}
