<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Codec;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers `StringCodec` as a service.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class StringCodec extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.codec.string.class',
            'Ramsey\Uuid\Codec\StringCodec'
        );

        $container->setDefinition(
            'kherge_uuid.codec.string',
            new Definition(
                '%kherge_uuid.codec.string.class%',
                [
                    new Reference($config['codec']['string']['uuid_builder'])
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return !empty($config['codec']['string']);
    }
}
