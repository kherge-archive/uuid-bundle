<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Registers `OpenSslGenerator` as a service.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class OpenSslGenerator extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.generator.openssl.class',
            'Ramsey\Uuid\Generator\OpenSslGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.generator.openssl',
            new Definition('%kherge_uuid.generator.openssl.class%')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function hasSettings(array $config)
    {
        return function_exists('openssl_random_pseudo_bytes');
    }
}
