<?php

namespace KHerGe\Bundle\UuidBundle\Serializer;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Ramsey\Uuid\UuidInterface;

/**
 * Registers a custom serialization handler for UUID objects.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class UuidHandler implements SubscribingHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'method' => 'toJson',
                'type' => 'Ramsey\Uuid\Uuid'
            ]
        ];
    }

    /**
     * Returns the UUID serialized for JSON.
     *
     * @param JsonSerializationVisitor $visitor The serialization visitor.
     * @param UuidInterface            $uuid    The UUID to serialize.
     * @param array                    $type    The type information.
     * @param Context                  $context The serialization context.
     *
     * @return string The serialized UUID.
     */
    public static function toJson(
        JsonSerializationVisitor $visitor,
        UuidInterface $uuid,
        array $type,
        Context $context
    ) {
        return $uuid->toString();
    }
}
