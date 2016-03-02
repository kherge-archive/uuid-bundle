<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Test;

use LogicException;
use Ramsey\Uuid\Generator\RandomGeneratorInterface;

/**
 * A test random generator.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class RandomGenerator implements RandomGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate($length)
    {
        throw new LogicException(
            'This a test implementation and must not be used.'
        );
    }
}
