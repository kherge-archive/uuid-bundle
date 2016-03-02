<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Test;

use LogicException;
use Ramsey\Uuid\Generator\TimeGeneratorInterface;

/**
 * A test time generator.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class TimeGenerator implements TimeGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate($node = null, $clockSeq = null)
    {
        throw new LogicException(
            'This a test implementation and must not be used.'
        );
    }
}
