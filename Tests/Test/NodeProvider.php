<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Test;

use LogicException;
use Ramsey\Uuid\Provider\NodeProviderInterface;

/**
 * A test node provider.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class NodeProvider implements NodeProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getNode()
    {
        throw new LogicException(
            'This a test implementation and must not be used.'
        );
    }
}
