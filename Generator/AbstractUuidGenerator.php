<?php

namespace KHerGe\Bundle\UuidBundle\Generator;

use Doctrine\ORM\Id\AbstractIdGenerator;
use Ramsey\Uuid\UuidFactoryInterface;

/**
 * Uses a UUID factory to generate new UUIDs.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
abstract class AbstractUuidGenerator extends AbstractIdGenerator
{
    /**
     * The UUID factory.
     *
     * @var UuidFactoryInterface
     */
    protected $factory;

    /**
     * Sets the UUID factory.
     *
     * @param UuidFactoryInterface $factory The UUID factory.
     */
    public function __construct(UuidFactoryInterface $factory)
    {
        $this->factory = $factory;
    }
}
