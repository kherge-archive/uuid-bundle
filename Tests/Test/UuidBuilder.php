<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Test;

use LogicException;
use Ramsey\Uuid\Builder\UuidBuilderInterface;
use Ramsey\Uuid\Codec\CodecInterface;

/**
 * A test time provider.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class UuidBuilder implements UuidBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function build(CodecInterface $codec, array $fields)
    {
        throw new LogicException(
            'This a test implementation and must not be used.'
        );
    }
}
