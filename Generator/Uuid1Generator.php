<?php

namespace KHerGe\Bundle\UuidBundle\Generator;

use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\UuidFactoryInterface;

/**
 * Generates v1 UUIDs for new entities.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class Uuid1Generator extends AbstractUuidGenerator
{
    /**
     * The clock sequence.
     *
     * @var integer
     */
    private $clock;

    /**
     * The hardware address node.
     *
     * @var integer|string
     */
    private $node;

    /**
     * Sets the UUID factory, hardware address node, and clock sequence.
     *
     * @param UuidFactoryInterface $factory The UUID factory.
     * @param integer|string       $node    The hardware address node.
     * @param integer              $clock   The clock sequence.
     */
    public function __construct(
        UuidFactoryInterface $factory,
        $node = null,
        $clock = null
    ) {
        parent::__construct($factory);

        $this->clock = $clock;
        $this->node = $node;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(EntityManager $em, $entity)
    {
        return $this->factory->uuid1($this->node, $this->clock);
    }
}
