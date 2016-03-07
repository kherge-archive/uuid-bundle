<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Generator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use KHerGe\Bundle\UuidBundle\Generator\Uuid1Generator;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;
use Ramsey\Uuid\UuidFactory;

/**
 * Verifies that the generator functions as intended.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 *
 * @coversDefaultClass \KHerGe\Bundle\UuidBundle\Generator\Uuid1Generator
 *
 * @covers ::__construct
 */
class Uuid1GeneratorTest extends TestCase
{
    /**
     * The clock sequence.
     *
     * @var string
     */
    private $clock;

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
     * @var Uuid1Generator
     */
    private $generator;

    /**
     * The mock entity manager.
     *
     * @var EntityManager|MockObject
     */
    private $manager;

    /**
     * The hardware address node.
     *
     * @var string
     */
    private $node;

    /**
     * Verify that the generator functions as intended.
     *
     * @covers ::generate
     */
    public function testGenerate()
    {
        $f = $this->factory->uuid1($this->node, $this->clock);
        $g = $this->generator->generate($this->manager, $this->entity);

        self::assertEquals($f->getClockSeqLowHex(), $g->getClockSeqLowHex());
        self::assertEquals($f->getNodeHex(), $g->getNodeHex());
    }

    /**
     * Sets up the generator.
     */
    protected function setUp()
    {
        $this->clock = '00';
        $this->node = '000000';

        $this->entity = new Entity();
        $this->manager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->factory = new UuidFactory();
        $this->generator = new Uuid1Generator(
            $this->factory,
            $this->node,
            $this->clock
        );
    }
}
