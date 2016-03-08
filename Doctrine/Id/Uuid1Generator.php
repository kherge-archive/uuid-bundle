<?php

namespace KHerGe\Bundle\UuidBundle\Doctrine\Id;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Ramsey\Uuid\Uuid;

/**
 * Generates v1 UUIDs.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
class Uuid1Generator extends AbstractIdGenerator
{
    /**
     * {@inheritdoc}
     *
     * @return Uuid The new UUID.
     */
    public function generate(EntityManager $em, $entity)
    {
        return Uuid::uuid1();
    }
}
