<?php

namespace KHerGe\Bundle\UuidBundle\Tests\DependencyInjection;

use KHerGe\Bundle\UuidBundle\DependencyInjection\KHerGeUuidExtension;
use KHerGe\Bundle\UuidBundle\Tests\Test;
use LogicException;
use PHPUnit_Framework_TestCase as TestCase;
use Ramsey\Uuid\FeatureSet;
use Ramsey\Uuid\UuidFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Verifies that the DIC extension functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Bundle\UuidBundle\DependencyInjection\KHerGeUuidExtension
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
     * Verifies that the extension registers the services as expected.
     *
     * @covers ::load
     * @covers ::registerFeatureSet
     * @covers ::registerUuidFactory
     */
    public function testLoad()
    {
        $this->load(
            [
                'feature_set' => [
                    'disable_big_number' => true,
                    'disable_system_node' => true,
                    'force_32bit' => true,
                    'use_guids' => true,
                    'use_pecl' => true
                ],
                'uuid_factory' => [
                    'global' => true
                ]
            ]
        );

        $this->assertFeatureSetCorrect();
        $this->assertUuidFactoryCorrect();
    }

    /**
     * Verifies that the extension registers the custom services as expected.
     *
     * @covers ::load
     * @covers ::registerFeatureSet
     * @covers ::registerUuidFactory
     */
    public function testLoadCustom()
    {
        $features = new Test\FeatureSet();

        $this->container->set('test.feature_set', $features);
        $this->container->set('test.number_converter', new Test\NumberConverter());
        $this->container->set('test.random_generator', new Test\RandomGenerator());
        $this->container->set('test.time_generator', new Test\TimeGenerator());
        $this->container->set('test.time_provider', new Test\TimeProvider());
        $this->container->set('test.uuid_builder', new Test\UuidBuilder());

        $this->load(
            [
                'feature_set' => [
                    'time_provider' => [
                        'id' => 'test.time_provider'
                    ]
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
                    ]
                ]
            ]
        );

        $this->assertCustomFeatureSetCorrect();
        $this->assertCustomUuidFactoryCorrect();
    }

    /**
     * Verifies that the node provider services are registered as expected.
     *
     * @covers ::load
     * @covers ::registerNodeProviders
     */
    public function testNodeProviders()
    {
        $this->load();

        $expected = [
            'kherge_uuid.node_provider.mt_rand' => 'Ramsey\Uuid\Provider\Node\RandomNodeProvider',
            'kherge_uuid.node_provider.system' => 'Ramsey\Uuid\Provider\Node\SystemNodeProvider',
        ];

        foreach ($expected as $id => $class) {
            self::assertInstanceOf($class, $this->container->get($id));
        }
    }

    /**
     * Verifies that the random generator services are registered as expected.
     *
     * @covers ::load
     * @covers ::registerRandomGenerators
     */
    public function testRandomGenerators()
    {
        $this->load();

        $expected = [
            'kherge_uuid.random_generator.mt_rand' => 'Ramsey\Uuid\Generator\MtRandGenerator',
            'kherge_uuid.random_generator.openssl' => 'Ramsey\Uuid\Generator\OpenSslGenerator',
            'kherge_uuid.random_generator.pecl_uuid' => 'Ramsey\Uuid\Generator\PeclUuidRandomGenerator',
            'kherge_uuid.random_generator.random_bytes' => 'Ramsey\Uuid\Generator\RandomBytesGenerator',
            'kherge_uuid.random_generator.sodium' => 'Ramsey\Uuid\Generator\SodiumRandomGenerator'
        ];

        foreach ($expected as $id => $class) {
            self::assertInstanceOf($class, $this->container->get($id));
        }
    }

    /**
     * Verify that using two conflicting settings throws an exception.
     *
     * @covers ::load
     * @covers ::registerFeatureSet
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The kherge_uuid.feature_set.use_pecl setting cannot
     */
    public function testSettingsConflict()
    {
        $this->load(
            [
                'feature_set' => [
                    'time_provider' => [
                        'id' => 'test.time_provider'
                    ],
                    'use_pecl' => true
                ]
            ]
        );
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
     * Asserts that the feature set service was defined correctly.
     */
    private function assertCustomFeatureSetCorrect()
    {
        /** @var FeatureSet $features */
        $features = $this->container->get('kherge_uuid.feature_set');

        self::assertInstanceOf(
            'Ramsey\Uuid\FeatureSet',
            $features
        );

        // use_guids = false
        self::assertInstanceOf(
            'Ramsey\Uuid\Codec\StringCodec',
            $features->getCodec()
        );

        // force_32bit = false
        self::assertInstanceOf(
            'Ramsey\Uuid\Builder\DefaultUuidBuilder',
            $features->getBuilder()
        );

        // disable_big_number = false
        self::assertInstanceOf(
            'Ramsey\Uuid\Converter\Number\BigNumberConverter',
            $features->getNumberConverter()
        );

        // disable_system_node = false
        self::assertInstanceOf(
            'Ramsey\Uuid\Provider\Node\FallbackNodeProvider',
            $features->getNodeProvider()
        );

        // use_pecl = false
        self::assertInstanceOf(
            'Ramsey\Uuid\Generator\DefaultTimeGenerator',
            $features->getTimeGenerator()
        );
    }

    /**
     * Asserts that the UUI factory set service was defined correctly.
     */
    private function assertCustomUuidFactoryCorrect()
    {
        /** @var UuidFactory $factory */
        $factory = $this->container->get('kherge_uuid.uuid_factory');

        self::assertInstanceOf(
            'Ramsey\Uuid\UuidFactory',
            $factory
        );

        // feature_set = test.feature_set
        self::assertInstanceOf(
            'KHerGe\Bundle\UuidBundle\Tests\Test\Codec',
            $factory->getCodec()
        );

        // feature_set = test.feature_set
        self::assertInstanceOf(
            'KHerGe\Bundle\UuidBundle\Tests\Test\NodeProvider',
            $factory->getNodeProvider()
        );

        // number_converter.id = test.number_converter
        self::assertInstanceOf(
            'KHerGe\Bundle\UuidBundle\Tests\Test\NumberConverter',
            $factory->getNumberConverter()
        );

        // random_generator.id = test.random_generator
        self::assertInstanceOf(
            'KHerGe\Bundle\UuidBundle\Tests\Test\RandomGenerator',
            $factory->getRandomGenerator()
        );

        // time_generator.id = test.time_generator
        try {
            $factory->getTimeGenerator()->generate();
        } catch (LogicException $exception) {
        }

        self::assertTrue(isset($exception));
    }

    /**
     * Asserts that the feature set service was defined correctly.
     */
    private function assertFeatureSetCorrect()
    {
        /** @var FeatureSet $features */
        $features = $this->container->get('kherge_uuid.feature_set');

        self::assertInstanceOf(
            'Ramsey\Uuid\FeatureSet',
            $features
        );

        // use_guids = true
        self::assertInstanceOf(
            'Ramsey\Uuid\Codec\GuidStringCodec',
            $features->getCodec()
        );

        // force_32bit = true
        self::assertInstanceOf(
            'Ramsey\Uuid\Builder\DegradedUuidBuilder',
            $features->getBuilder()
        );

        // disable_big_number = true
        self::assertInstanceOf(
            'Ramsey\Uuid\Converter\Number\DegradedNumberConverter',
            $features->getNumberConverter()
        );

        // disable_system_node = true
        self::assertInstanceOf(
            'Ramsey\Uuid\Provider\Node\RandomNodeProvider',
            $features->getNodeProvider()
        );

        // use_pecl = true
        self::assertInstanceOf(
            'Ramsey\Uuid\Generator\PeclUuidTimeGenerator',
            $features->getTimeGenerator()
        );
    }

    /**
     * Asserts that the UUI factory set service was defined correctly.
     */
    private function assertUuidFactoryCorrect()
    {
        /** @var UuidFactory $factory */
        $factory = $this->container->get('kherge_uuid.uuid_factory');

        /** @var FeatureSet $features */
        $features = $this->container->get('kherge_uuid.feature_set');

        self::assertInstanceOf(
            'Ramsey\Uuid\UuidFactory',
            $factory
        );

        // kherge.uuid_factory.feature_set = test.feature_set
        self::assertSame(
            $features->getCodec(),
            $factory->getCodec()
        );

        self::assertSame(
            $features->getNodeProvider(),
            $factory->getNodeProvider()
        );

        self::assertSame(
            $features->getNumberConverter(),
            $factory->getNumberConverter()
        );

        self::assertSame(
            $features->getRandomGenerator(),
            $factory->getRandomGenerator()
        );

        self::assertSame(
            $features->getTimeGenerator(),
            $factory->getTimeGenerator()
        );
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
}
