<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Test;

use LogicException;
use Ramsey\Uuid\Converter\NumberConverterInterface;

/**
 * A test number converter.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class NumberConverter implements NumberConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function fromHex($hex)
    {
        throw new LogicException(
            'This a test implementation and must not be used.'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function toHex($integer)
    {
        throw new LogicException(
            'This a test implementation and must not be used.'
        );
    }
}
