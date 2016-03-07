<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Generator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use KHerGe\Bundle\UuidBundle\Generator\Uuid4Generator;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;
use Ramsey\Uuid\UuidFactory;

/**
 * Verifies that the generator functions as intended.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 *
 * @coversDefaultClass \KHerGe\Bundle\UuidBundle\Generator\Uuid4Generator
 *
 * @covers ::__construct
 */
class Uuid4GeneratorTest extends TestCase
{
    /**
     * The mock entity.
     *
     * @var Entity
     */
    private $entity;

    /**
     * The UUID factory.
     *
     * @var UuidFactory
     */
    private $factory;

    /**
     * The generator.
     *
     * @var Uuid4Generator
     */
    private $generator;

    /**
     * The mock entity manager.
     *
     * @var EntityManager|MockObject
     */
    private $manager;

    /**
     * Verify that the generator functions as intended.
     *
     * @covers ::generate
     */
    public function testGenerate()
    {
        self::assertInstanceOf(
            'Ramsey\Uuid\Uuid',
            $this->generator->generate($this->manager, $this->entity)
        );
    }

    /**
     * Sets up the generator.
     */
    protected function setUp()
    {
        $this->entity = new Entity();
        $this->manager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->factory = new UuidFactory();
        $this->generator = new Uuid4Generator($this->factory);
    }
}
