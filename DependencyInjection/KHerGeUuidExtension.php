<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Consumes the bundle settings to register services.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class KHerGeUuidExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(
            new Configuration(),
            $configs
        );

        $this->registerFeatureSet($container, $config);
        $this->registerNodeProviders($container);
        $this->registerRandomGenerators($container);
        $this->registerUuidFactory($container, $config);
    }

    /**
     * Registers the feature set service with the DIC.
     *
     * @param ContainerBuilder $container The DIC builder.
     * @param array            $config    The bundle settings.
     */
    private function registerFeatureSet(
        ContainerBuilder $container,
        array $config
    ) {
        if (!$container->hasParameter('kherge_uuid.feature_set.class')) {
            $container->setParameter(
                'kherge_uuid.feature_set.class',
                'Ramsey\Uuid\FeatureSet'
            );
        }

        $definition = new Definition(
            '%kherge_uuid.feature_set.class%',
            [
                $config['feature_set']['use_guids'],
                $config['feature_set']['force_32bit'],
                $config['feature_set']['disable_big_number'],
                $config['feature_set']['disable_system_node'],
                $config['feature_set']['use_pecl'],
            ]
        );

        if (isset($config['feature_set']['time_provider'])) {
            if ($config['feature_set']['use_pecl']) {
                throw new InvalidConfigurationException(
                    'The kherge_uuid.feature_set.use_pecl setting cannot be '
                        . 'enabled while also specifying a time provider '
                        . 'service through the kherge_uuid.feature_set.time_provider '
                        . 'setting. Please use only one.'
                );
            }

            $definition->addMethodCall(
                'setTimeProvider',
                [
                    new Reference($config['feature_set']['time_provider']['id'])
                ]
            );
        }

        $container->setDefinition('kherge_uuid.feature_set', $definition);
    }

    /**
     * Registers the node provider services with the DIC.
     *
     * @param ContainerBuilder $container The DIC builder.
     */
    private function registerNodeProviders(ContainerBuilder $container)
    {
        // @todo Create another node provider that uses RandomGeneratorInterface.

        // RandomNodeProvider
        $container->setParameter(
            'kherge_uuid.node_provider.mt_rand.class',
            'Ramsey\Uuid\Provider\Node\RandomNodeProvider'
        );

        $container->setDefinition(
            'kherge_uuid.node_provider.mt_rand',
            new Definition('%kherge_uuid.node_provider.mt_rand.class%')
        );

        // SystemNodeProvider
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
     * Registers the random generator services with the DIC.
     *
     * @param ContainerBuilder $container The DIC builder.
     */
    private function registerRandomGenerators(ContainerBuilder $container)
    {
        // MtRandGenerator
        $container->setParameter(
            'kherge_uuid.random_generator.mt_rand.class',
            'Ramsey\Uuid\Generator\MtRandGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.random_generator.mt_rand',
            new Definition('%kherge_uuid.random_generator.mt_rand.class%')
        );

        // OpenSslGenerator
        $container->setParameter(
            'kherge_uuid.random_generator.openssl.class',
            'Ramsey\Uuid\Generator\OpenSslGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.random_generator.openssl',
            new Definition('%kherge_uuid.random_generator.openssl.class%')
        );

        // PeclUuidRandomGenerator
        $container->setParameter(
            'kherge_uuid.random_generator.pecl_uuid.class',
            'Ramsey\Uuid\Generator\PeclUuidRandomGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.random_generator.pecl_uuid',
            new Definition('%kherge_uuid.random_generator.pecl_uuid.class%')
        );

        // RandomBytesGenerator
        $container->setParameter(
            'kherge_uuid.random_generator.random_bytes.class',
            'Ramsey\Uuid\Generator\RandomBytesGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.random_generator.random_bytes',
            new Definition('%kherge_uuid.random_generator.random_bytes.class%')
        );

        // SodiumRandomGenerator
        $container->setParameter(
            'kherge_uuid.random_generator.sodium.class',
            'Ramsey\Uuid\Generator\SodiumRandomGenerator'
        );

        $container->setDefinition(
            'kherge_uuid.random_generator.sodium',
            new Definition('%kherge_uuid.random_generator.sodium.class%')
        );
    }

    /**
     * Registers the UUID factory service with the DIC.
     *
     * @param ContainerBuilder $container The DIC builder.
     * @param array            $config    The bundle settings.
     */
    private function registerUuidFactory(
        ContainerBuilder $container,
        array $config
    ) {
        $container->setParameter(
            'kherge_uuid.uuid_factory.global',
            $config['uuid_factory']['global']
        );

        if (!$container->hasParameter('kherge_uuid.uuid_factory.class')) {
            $container->setParameter(
                'kherge_uuid.uuid_factory.class',
                'Ramsey\Uuid\UuidFactory'
            );
        }

        $definition = new Definition(
            '%kherge_uuid.uuid_factory.class%',
            [
                new Reference($config['uuid_factory']['feature_set']['id'])
            ]
        );

        if (isset($config['uuid_factory']['number_converter'])) {
            $definition->addMethodCall(
                'setNumberConverter',
                [
                    new Reference(
                        $config['uuid_factory']['number_converter']['id']
                    )
                ]
            );
        }

        if (isset($config['uuid_factory']['random_generator'])) {
            $definition->addMethodCall(
                'setRandomGenerator',
                [
                    new Reference(
                        $config['uuid_factory']['random_generator']['id']
                    )
                ]
            );
        }

        if (isset($config['uuid_factory']['time_generator'])) {
            $definition->addMethodCall(
                'setTimeGenerator',
                [
                    new Reference(
                        $config['uuid_factory']['time_generator']['id']
                    )
                ]
            );
        }

        if (isset($config['uuid_factory']['uuid_builder'])) {
            $definition->addMethodCall(
                'setUuidBuilder',
                [
                    new Reference(
                        $config['uuid_factory']['uuid_builder']['id']
                    )
                ]
            );
        }

        $container->setDefinition('kherge_uuid.uuid_factory', $definition);
    }
}
