<?php

namespace KHerGe\Bundle\UuidBundle\Tests;

use KHerGe\Bundle\UuidBundle\DependencyInjection\KHerGeUuidExtension;
use KHerGe\Bundle\UuidBundle\KHerGeUuidBundle;
use PHPUnit_Framework_TestCase as TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Verifies that the bundle class functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Bundle\UuidBundle\KHerGeUuidBundle
 */
class KHerGeUuidBundleTest extends TestCase
{
    /**
     * The bundle.
     *
     * @var KHerGeUuidBundle
     */
    private $bundle;

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
     * Verify that the factory is made global.
     *
     * @covers ::boot
     */
    public function testGlobalFactory()
    {
        $this->load(
            [
                'uuid_factory' => [
                    'global' => true
                ]
            ]
        );

        $this->bundle->boot();

        self::assertSame(
            $this->container->get('kherge_uuid.uuid_factory'),
            Uuid::getFactory()
        );
    }

    /**
     * Verify that the method override functions as intended.
     *
     * @covers ::getContainerExtension
     */
    public function testGetContainerExtensionOverride()
    {
        self::assertInstanceOf(
            'KHerGe\Bundle\UuidBundle\DependencyInjection\KHerGeUuidExtension',
            $this->bundle->getContainerExtension()
        );
    }

    /**
     * Creates the processor and configuration tree builder.
     */
    protected function setUp()
    {
        $this->bundle = new KHerGeUuidBundle();
        $this->container = new ContainerBuilder();
        $this->extension = new KHerGeUuidExtension();

        $this->bundle->setContainer($this->container);
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
