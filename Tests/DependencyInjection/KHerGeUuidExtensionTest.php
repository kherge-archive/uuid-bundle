<?php

namespace KHerGe\Bundle\UuidBundle\Tests\DependencyInjection;

use InvalidArgumentException;
use KHerGe\Bundle\UuidBundle\DependencyInjection\KHerGeUuidExtension;
use PHPUnit_Framework_TestCase as TestCase;
use RandomLib\Generator;
use RandomLib\Mixer\Hash;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Verifies that the DIC extension functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Builder\DefaultUuidBuilder
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Builder\DegradedUuidBuilder
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Codec\GuidStringCodec
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Codec\StringCodec
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Converter\Number\BigNumberConverter
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Converter\Number\DegradedNumberConverter
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Converter\Time\BigNumberTimeConverter
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Converter\Time\DegradedTimeConverter
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Converter\Time\PhpTimeConverter
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\FeatureSet
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator\CombGenerator
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator\DefaultTimeGenerator
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator\MtRandGenerator
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator\OpenSslGenerator
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator\PeclUuidRandomGenerator
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator\PeclUuidTimeGenerator
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator\RandomBytesGenerator
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator\RandomLibAdapter
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Generator\SodiumRandomGenerator
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Provider\Node\FallbackNodeProvider
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Provider\Node\RandomNodeProvider
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Provider\Node\SystemNodeProvider
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Provider\Time\FixedTimeProvider
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\Provider\Time\SystemTimeProvider
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\UuidFactory
 * @covers \KHerGe\Bundle\UuidBundle\DependencyInjection\KHerGeUuidExtension
 */
class KHerGeUuidExtensionTest extends TestCase
{
    /**
     * The DIC builder.
     *
     * @var ContainerBuilder
     */
    private $container;

    /**
     * The bundle extension.
     *
     * @var KHerGeUuidExtension
     */
    private $extension;

    /**
     * Returns a list of expectations for services registered by the extension.
     *
     * @return array The list of expectations.
     */
    public function getExpectations()
    {
        return [

            // 0
            [
                'kherge_uuid.builder.default',
                'Ramsey\Uuid\Builder\DefaultUuidBuilder',
                [
                    'property' => [
                        'converter' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.number_converter.degraded',
                                $value
                            );
                        }
                    ]
                ]
            ],

            // 1
            [
                'kherge_uuid.builder.degraded',
                'Ramsey\Uuid\Builder\DegradedUuidBuilder',
                [
                    'property' => [
                        'converter' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.number_converter.degraded',
                                $value
                            );
                        }
                    ]
                ]
            ],

            // 2
            [
                'kherge_uuid.codec.guid',
                'Ramsey\Uuid\Codec\GuidStringCodec',
                [
                    'property' => [
                        'builder' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.builder.default',
                                $value
                            );
                        }
                    ]
                ]
            ],

            // 3
            [
                'kherge_uuid.codec.string',
                'Ramsey\Uuid\Codec\StringCodec',
                [
                    'property' => [
                        'builder' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.builder.default',
                                $value
                            );
                        }
                    ]
                ]
            ],

            // 4
            [
                'kherge_uuid.number_converter.big_number',
                'Ramsey\Uuid\Converter\Number\BigNumberConverter'
            ],

            // 5
            [
                'kherge_uuid.number_converter.degraded',
                'Ramsey\Uuid\Converter\Number\DegradedNumberConverter'
            ],

            // 6
            [
                'kherge_uuid.time_converter.big_number',
                'Ramsey\Uuid\Converter\Time\BigNumberTimeConverter'
            ],

            // 6
            [
                'kherge_uuid.time_converter.degraded',
                'Ramsey\Uuid\Converter\Time\DegradedTimeConverter'
            ],

            // 8
            [
                'kherge_uuid.time_converter.php',
                'Ramsey\Uuid\Converter\Time\PhpTimeConverter'
            ],

            // 9
            [
                'kherge_uuid.generator.comb',
                'Ramsey\Uuid\Generator\CombGenerator',
                [
                    'property' => [
                        'randomGenerator' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.generator.mt_rand',
                                $value
                            );
                        },
                        'converter' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.number_converter.degraded',
                                $value
                            );
                        }
                    ]
                ]
            ],

            // 10
            [
                'kherge_uuid.generator.default_time',
                'Ramsey\Uuid\Generator\DefaultTimeGenerator',
                [
                    'property' => [
                        'nodeProvider' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.node_provider.system',
                                $value
                            );
                        },
                        'timeConverter' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.time_converter.degraded',
                                $value
                            );
                        },
                        'timeProvider' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.time_provider.system',
                                $value
                            );
                        }
                    ]
                ]
            ],

            // 11
            [
                'kherge_uuid.generator.mt_rand',
                'Ramsey\Uuid\Generator\MtRandGenerator'
            ],

            // 12
            [
                'kherge_uuid.generator.openssl',
                'Ramsey\Uuid\Generator\OpenSslGenerator'
            ],

            // 13
            [
                'kherge_uuid.generator.pecl_uuid_random',
                'Ramsey\Uuid\Generator\PeclUuidRandomGenerator'
            ],

            // 14
            [
                'kherge_uuid.generator.pecl_uuid_time',
                'Ramsey\Uuid\Generator\PeclUuidTimeGenerator'
            ],

            // 15
            [
                'kherge_uuid.generator.random_bytes',
                'Ramsey\Uuid\Generator\RandomBytesGenerator'
            ],

            // 16
            [
                'kherge_uuid.generator.random_lib',
                'Ramsey\Uuid\Generator\RandomLibAdapter',
                [
                    'config' => [
                        'generator' => [
                            'random_lib' => [
                                'generator' => 'test.generator'
                            ]
                        ]
                    ],
                    'property' => [
                        'generator' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'test.generator',
                                $value
                            );
                        }
                    ],
                    'setup' => function (ContainerBuilder $container) {
                        $container->set(
                            'test.generator',
                            new Generator([], new Hash())
                        );
                    }
                ]
            ],

            // 17
            [
                'kherge_uuid.generator.sodium',
                'Ramsey\Uuid\Generator\SodiumRandomGenerator'
            ],

            // 18
            [
                'kherge_uuid.node_provider.fallback',
                'Ramsey\Uuid\Provider\Node\FallbackNodeProvider',
                [
                    'config' => [
                        'node_provider' => [
                            'fallback' => [
                                'kherge_uuid.node_provider.system',
                                'kherge_uuid.node_provider.random'
                            ]
                        ]
                    ],
                    'property' => [
                        'nodeProviders' => [
                            function ($container) {
                                /** @var ContainerBuilder $container */
                                return $container->get(
                                    'kherge_uuid.node_provider.system'
                                );
                            },
                            function ($container) {
                                /** @var ContainerBuilder $container */
                                return $container->get(
                                    'kherge_uuid.node_provider.random'
                                );
                            }
                        ]
                    ]
                ]
            ],

            // 19
            [
                'kherge_uuid.node_provider.random',
                'Ramsey\Uuid\Provider\Node\RandomNodeProvider'
            ],

            // 20
            [
                'kherge_uuid.node_provider.system',
                'Ramsey\Uuid\Provider\Node\SystemNodeProvider'
            ],

            // 21
            [
                'kherge_uuid.time_provider.fixed',
                'Ramsey\Uuid\Provider\Time\FixedTimeProvider',
                [
                    'config' => [
                        'time_provider' => [
                            'fixed' => [
                                'sec' => 123,
                                'usec' => 456
                            ]
                        ]
                    ],
                    'property' => [
                        'fixedTime' => [
                            'sec' => 123,
                            'usec' => 456
                        ]
                    ]
                ]
            ],

            // 22
            [
                'kherge_uuid.time_provider.system',
                'Ramsey\Uuid\Provider\Time\SystemTimeProvider'
            ],

            // 23
            [
                'kherge_uuid.feature_set',
                'Ramsey\Uuid\FeatureSet',
                [
                    'config' => [
                        'feature_set' => [
                            'disable_big_number' => true,
                            'disable_system_node' => true,
                            'force_32bit' => true,
                            'use_guids' => true,
                            'use_pecl' => true,
                        ]
                    ],
                    'property' => [
                        'builder' => function ($value) {
                            self::assertInstanceOf(
                                'Ramsey\Uuid\Builder\DegradedUuidBuilder',
                                $value
                            );
                        },
                        'codec' => function ($value) {
                            self::assertInstanceOf(
                                'Ramsey\Uuid\Codec\GuidStringCodec',
                                $value
                            );
                        },
                        'disableBigNumber' => true,
                        'disable64Bit' => true,
                        'enablePecl' => true,
                        'ignoreSystemNode' => true,
                        'timeGenerator' => function ($value) {
                            self::assertInstanceOf(
                                'Ramsey\Uuid\Generator\PeclUuidTimeGenerator',
                                $value
                            );
                        }
                    ]
                ]
            ],

            // 24
            [
                'kherge_uuid.feature_set',
                'Ramsey\Uuid\FeatureSet',
                [
                    'property' => [
                        'timeGenerator' => function ($value, $container) {
                            /** @var ContainerBuilder $container */
                            self::assertSame(
                                $container->get('kherge_uuid.time_provider.system'),
                                $this->getValue($value, 'timeProvider')
                            );
                        }
                    ]
                ]
            ],

            // 25
            [
                'kherge_uuid.uuid_factory',
                'Ramsey\Uuid\UuidFactory',
                [
                    'config' => [
                        'uuid_factory' => [
                            'number_converter' => null,
                            'random_generator' => null,
                            'time_generator' => null,
                            'uuid_builder' => null,
                        ]
                    ],
                    'property' => [
                        'codec' => function ($value, $container) {
                            /** @var ContainerBuilder $container */
                            self::assertSame(
                                $container
                                    ->get('kherge_uuid.feature_set')
                                    ->getCodec(),
                                $value,
                                'The codec for `FeatureSet` and `UuidBuilder` should be identical.'
                            );
                        },
                        'nodeProvider' => function ($value, $container) {
                            /** @var ContainerBuilder $container */
                            self::assertSame(
                                $container
                                    ->get('kherge_uuid.feature_set')
                                    ->getNodeProvider(),
                                $value,
                                'The node provider for `FeatureSet` and `UuidBuilder` should be identical.'
                            );
                        },
                        'numberConverter' => function ($value, $container) {
                            /** @var ContainerBuilder $container */
                            self::assertSame(
                                $container
                                    ->get('kherge_uuid.feature_set')
                                    ->getNumberConverter(),
                                $value,
                                'The number converter for `FeatureSet` and `UuidBuilder` should be identical.'
                            );
                        },
                        'randomGenerator' => function ($value, $container) {
                            /** @var ContainerBuilder $container */
                            self::assertSame(
                                $container
                                    ->get('kherge_uuid.feature_set')
                                    ->getRandomGenerator(),
                                $value,
                                'The random generator for `FeatureSet` and `UuidBuilder` should be identical.'
                            );
                        },
                        'timeGenerator' => function ($value, $container) {
                            /** @var ContainerBuilder $container */
                            self::assertSame(
                                $container
                                    ->get('kherge_uuid.feature_set')
                                    ->getTimeGenerator(),
                                $value,
                                'The time generator for `FeatureSet` and `UuidBuilder` should be identical.'
                            );
                        },
                        'uuidBuilder' => function ($value, $container) {
                            /** @var ContainerBuilder $container */
                            self::assertSame(
                                $container
                                    ->get('kherge_uuid.feature_set')
                                    ->getBuilder(),
                                $value,
                                'The UUID bulider for `FeatureSet` and `UuidBuilder` should be identical.'
                            );
                        }
                    ]
                ]
            ],

            // 26
            [
                'kherge_uuid.uuid_factory',
                'Ramsey\Uuid\UuidFactory',
                [
                    'property' => [
                        'numberConverter' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.number_converter.degraded',
                                $value
                            );
                        },
                        'randomGenerator' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.generator.mt_rand',
                                $value
                            );
                        },
                        'timeGenerator' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.generator.default_time',
                                $value
                            );
                        },
                        'uuidBuilder' => function ($value, $container) {
                            $this->assertService(
                                $container,
                                'kherge_uuid.builder.default',
                                $value
                            );
                        }
                    ]
                ]
            ],

            // 27
            [
                'kherge_uuid.param_converter',
                'KHerGe\Bundle\UuidBundle\Request\UuidParamConverter'
            ]
        ];
    }

    /**
     * Verify that a service has been registered properly.
     *
     * @param string $id    The service identifier.
     * @param string $class The expected class for the object.
     * @param array  $add   Additional expectations.
     *
     * @dataProvider getExpectations
     */
    public function testExpectation($id, $class, array $add = null)
    {
        if (null === $add) {
            $add = [];
        }

        if (isset($add['setup'])) {
            $add['setup']($this->container);
        }

        $this->load(isset($add['config']) ? $add['config'] : []);

        self::assertTrue(
            $this->container->has($id),
            "The service container should have the \"$id\" service registered."
        );

        $service = $this->container->get($id);

        self::assertInstanceOf(
            $class,
            $service,
            sprintf(
                'The service "%s" should be an instance of "%s" but "%s" was found instead.',
                $id,
                $class,
                get_class($service)
            )
        );

        if (isset($add['property'])) {
            foreach ($add['property'] as $name => $expected) {
                $actual = $this->getValue($service, $name);

                if (is_callable($expected)) {
                    $expected($actual, $this->container);
                } else {
                    $this->resolveCallbacks($expected, $this->container);

                    self::assertEquals($expected, $actual);
                }
            }
        }
    }

    /**
     * Creates the processor and configuration tree builder.
     */
    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new KHerGeUuidExtension();
    }

    /**
     * Asserts that a given value is a service.
     *
     * @param ContainerBuilder $container The DIC builder.
     * @param string           $id        The service identifier.
     * @param object           $actual    The actual service object.
     */
    private function assertService(ContainerBuilder $container, $id, $actual)
    {
        self::assertSame(
            $container->get($id),
            $actual
        );
    }

    /**
     * Returns the value of a property.
     *
     * @param object $object   The object.
     * @param string $property The name of the property.
     *
     * @return mixed The value of the property.
     *
     * @throws InvalidArgumentException If the property does not exist.
     */
    private function getValue($object, $property)
    {
        $reflection = new ReflectionClass($object);

        while (!$reflection->hasProperty($property)) {
            if (!($reflection = $reflection->getParentClass())) {
                throw new InvalidArgumentException(
                    sprintf(
                        'The class "%s" does not have the property "%s".',
                        get_class($object),
                        $property
                    )
                );
            }
        }

        $reflection = $reflection->getProperty($property);
        $reflection->setAccessible(true);

        return $reflection->getValue($object);
    }

    /**
     * Loads the extension with the given settings into the DIC builder.
     *
     * @param array $config The bundle settings.
     */
    private function load(array $config = [])
    {
        if (!empty($config)) {
            $config = [$config];
        }

        $this->extension->load($config, $this->container);
    }

    /**
     * Resolves callbacks inside of an expected value.
     *
     * @param array|callable   &$expected The expected value.
     * @param ContainerBuilder $container The DIC builder.
     */
    private function resolveCallbacks(&$expected, ContainerBuilder $container)
    {
        if (is_callable($expected)) {
            $expected = $expected($container);
        } elseif (is_array($expected)) {
            foreach ($expected as $key => &$value) {
                $this->resolveCallbacks($value, $container);
            }
        }
    }
}
