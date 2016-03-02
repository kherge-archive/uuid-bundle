<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Test;

use LogicException;
use Ramsey\Uuid\Codec\CodecInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * A test codec.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Codec implements CodecInterface
{
    /**
     * {@inheritdoc}
     */
    public function encode(UuidInterface $uuid)
    {
        throw new LogicException(
            'This a test implementation and must not be used.'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function encodeBinary(UuidInterface $uuid)
    {
        throw new LogicException(
            'This a test implementation and must not be used.'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function decode($encodedUuid)
    {
        throw new LogicException(
            'This a test implementation and must not be used.'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function decodeBytes($bytes)
    {
        throw new LogicException(
            'This a test implementation and must not be used.'
        );
    }
}
