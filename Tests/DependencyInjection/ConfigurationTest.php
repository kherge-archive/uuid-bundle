<?php

namespace KHerGe\Bundle\UuidBundle\Tests\DependencyInjection;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\Config\Definition\Processor;

/**
 * Verifies that the DIC setting definitions work as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Builder\DefaultUuidBuilder
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Builder\DegradedUuidBuilder
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Codec\GuidStringCodec
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Codec\StringCodec
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\FeatureSet
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Generator\CombGenerator
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Generator\DefaultTimeGenerator
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Generator\RandomLibAdapter
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Provider\Node\FallbackNodeProvider
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Provider\Time\FixedTimeProvider
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\Serializer\UuidHandler
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Configuration\UuidFactory
 */
class ConfigurationTest extends TestCase
{
    /**
     * The configuration tree builder.
     *
     * @var Configuration
     */
    private $configuration;

    /**
     * The configuration processor.
     *
     * @var Processor
     */
    private $processor;

    /**
     * Verify that all of the default settings are present.
     */
    public function testDefaults()
    {
        self::assertEquals(
            [
                'builder' => [
                    'default' => [
                        'number_converter' => 'kherge_uuid.number_converter.degraded'
                    ],
                    'degraded' => [
                        'number_converter' => 'kherge_uuid.number_converter.degraded'
                    ]
                ],
                'codec' => [
                    'guid' => [
                        'uuid_builder' => 'kherge_uuid.builder.default'
                    ],
                    'string' => [
                        'uuid_builder' => 'kherge_uuid.builder.default'
                    ]
                ],
                'generator' => [
                    'comb' => [
                        'random_generator' => 'kherge_uuid.generator.mt_rand',
                        'number_converter' => 'kherge_uuid.number_converter.degraded'
                    ],
                    'default_time' => [
                        'node_provider' => 'kherge_uuid.node_provider.system',
                        'time_converter' => 'kherge_uuid.time_converter.degraded',
                        'time_provider' => 'kherge_uuid.time_provider.system'
                    ]
                ],
                'feature_set' => [
                    'disable_big_number' => false,
                    'disable_system_node' => false,
                    'force_32bit' => false,
                    'time_provider' => 'kherge_uuid.time_provider.system',
                    'use_guids' => false,
                    'use_pecl' => false
                ],
                'param_converter' => true,
                'uuid_factory' => [
                    'feature_set' => 'kherge_uuid.feature_set',
                    'global' => false,
                    'number_converter' => 'kherge_uuid.number_converter.degraded',
                    'random_generator' => 'kherge_uuid.generator.mt_rand',
                    'time_generator' => 'kherge_uuid.generator.default_time',
                    'uuid_builder' => 'kherge_uuid.builder.default'
                ],
                'serializer' => [
                    'uuid_handler' => true
                ]
            ],
            $this->processConfig()
        );
    }

    /**
     * Creates the processor and configuration tree builder.
     */
    protected function setUp()
    {
        $this->configuration = new Configuration();
        $this->processor = new Processor();
    }

    /**
     * Processes the configuration tree builder.
     *
     * @param array $configs The input configurations.
     *
     * @return array The configuration settings.
     */
    private function processConfig(array $configs = [])
    {
        return $this->processor->processConfiguration(
            $this->configuration,
            $configs
        );
    }
}
