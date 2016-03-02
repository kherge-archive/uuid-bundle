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
 * @coversDefaultClass \KHerGe\Bundle\Uuidbundle\DependencyInjection\Configuration
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
     * Verifies that the default settings are defined as expected.
     *
     * @covers ::getConfigTreeBuilder
     * @covers ::addFeatureSet
     * @covers ::addUuidFactory
     */
    public function testDefaults()
    {
        self::assertEquals(
            [
                'feature_set' => [
                    'disable_big_number' => false,
                    'disable_system_node' => false,
                    'force_32bit' => false,
                    'use_guids' => false,
                    'use_pecl' => false,
                ],
                'uuid_factory' => [
                    'feature_set' => [
                        'id' => 'kherge_uuid.feature_set'
                    ],
                    'global' => false
                ]
            ],
            $this->processConfig()
        );
    }

    /**
     * Verifies that user provided settings are validated as expected.
     *
     * @covers ::getConfigTreeBuilder
     * @covers ::addFeatureSet
     * @covers ::addUuidFactory
     */
    public function testProcess()
    {
        self::assertEquals(
            [
                'feature_set' => [
                    'disable_big_number' => false,
                    'disable_system_node' => false,
                    'force_32bit' => false,
                    'time_provider' => [
                        'id' => 'test.time_provider'
                    ],
                    'use_guids' => false,
                    'use_pecl' => true,
                ],
                'uuid_factory' => [
                    'feature_set' => [
                        'id' => 'test.feature_set'
                    ],
                    'global' => true,
                    'number_converter' => [
                        'id' => 'test.number_converter'
                    ],
                    'random_generator' => [
                        'id' => 'test.random_generator'
                    ],
                    'time_generator' => [
                        'id' => 'test.time_generator'
                    ],
                    'uuid_builder' => [
                        'id' => 'test.uuid_builder'
                    ],
                ]
            ],
            $this->processConfig(
                [
                    [
                        'feature_set' => [
                            'time_provider' => [
                                'id' => 'test.time_provider'
                            ],
                            'use_pecl' => true,
                        ],
                        'uuid_factory' => [
                            'feature_set' => [
                                'id' => 'test.feature_set'
                            ],
                            'global' => true,
                            'number_converter' => [
                                'id' => 'test.number_converter'
                            ],
                            'random_generator' => [
                                'id' => 'test.random_generator'
                            ],
                            'time_generator' => [
                                'id' => 'test.time_generator'
                            ],
                            'uuid_builder' => [
                                'id' => 'test.uuid_builder'
                            ],
                        ]
                    ]
                ]
            )
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
