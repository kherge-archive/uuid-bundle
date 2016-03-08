<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Doctrine\Id;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use KHerGe\Bundle\UuidBundle\Doctrine\Id\Uuid4Generator;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Verifies that the UUID generator functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Bundle\UuidBundle\Doctrine\Id\Uuid4Generator
 */
class Uuid4GeneratorTest extends TestCase
{
    /**
     * The mock entity.
     *
     * @var Entity|object
     */
    private $entity;

    /**
     * The mock entity manager.
     *
     * @var EntityManager|MockObject
     */
    private $manager;

    /**
     * The UUID generator.
     *
     * @var Uuid4Generator
     */
    private $generator;

    /**
     * Verifies that a new UUID is generated.
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
     * Sets up the generator, entity manager, and entity.
     */
    protected function setUp()
    {
        $this->entity = (object) [];
        $this->generator = new Uuid4Generator();
        $this->manager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}
