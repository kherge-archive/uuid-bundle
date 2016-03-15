<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Serializer;

use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use KHerGe\Bundle\UuidBundle\Serializer\UuidHandler;
use PHPUnit_Framework_TestCase as TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Verifies that the serialization handler functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Bundle\UuidBundle\Serializer\UuidHandler
 *
 * @covers ::getSubscribingMethods
 */
class UuidHandlerTest extends TestCase
{
    /**
     * The serializer.
     *
     * @var Serializer
     */
    private $serializer;

    /**
     * Verify that the UUID object is serialized as expected.
     *
     * @covers ::toJson
     */
    public function testSerializeToJson()
    {
        $uuid = Uuid::fromString(Uuid::NIL);
        $expect = sprintf('{"uuid":"%s"}', $uuid->toString());

        self::assertEquals(
            $expect,
            $this->serializer->serialize(['uuid' => $uuid], 'json')
        );
    }

    /**
     * Sets up the serializer with the handler.
     */
    protected function setUp()
    {
        $this->serializer = SerializerBuilder::create()
            ->configureHandlers(
                function (HandlerRegistry $registry) {
                    $registry->registerSubscribingHandler(new UuidHandler());
                }
            )
            ->build()
        ;
    }
}
