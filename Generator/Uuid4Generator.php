<?php

namespace KHerGe\Bundle\UuidBundle\Generator;

use Doctrine\ORM\EntityManager;

/**
 * Generates v4 UUIDs for entities.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class Uuid4Generator extends AbstractUuidGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generate(EntityManager $em, $entity)
    {
        return $this->factory->uuid4();
    }
}
