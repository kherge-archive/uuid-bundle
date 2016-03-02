<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Test;

use LogicException;
use Ramsey\Uuid\Provider\TimeProviderInterface;

/**
 * A test time provider.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class TimeProvider implements TimeProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function currentTime()
    {
        throw new LogicException(
            'This a test implementation and must not be used.'
        );
    }
}
