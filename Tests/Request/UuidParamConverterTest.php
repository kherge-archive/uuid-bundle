<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Request;

use KHerGe\Bundle\UuidBundle\Request\UuidParamConverter;
use PHPUnit_Framework_TestCase as TestCase;
use Ramsey\Uuid\UuidFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Verifies that the UUID parameter converter functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Bundle\UuidBundle\Request\UuidParamConverter
 *
 * @covers ::__construct
 */
class UuidParamConverterTest extends TestCase
{
    /**
     * The parameter converter.
     *
     * @var UuidParamConverter
     */
    private $converter;

    /**
     * The UUID factory.
     *
     * @var UuidFactory
     */
    private $factory;

    /**
     * Verify that invalid parameters are not converted.
     *
     * @covers ::apply
     */
    public function testDoesNotApplyToInvalidUuid()
    {
        $request = Request::create('');
        $converter = new ParamConverter(
            [
                'name' => 'uuid',
                'options' => [
                    'uuid' => true
                ]
            ]
        );

        self::assertFalse($this->converter->apply($request, $converter));
        self::assertNull($request->attributes->get('uuid'));

        $request->attributes->set('uuid', 'test');

        self::assertFalse($this->converter->apply($request, $converter));
        self::assertEquals('test', $request->attributes->get('uuid'));
    }

    /**
     * Verify that a valid parameter is converted.
     *
     * @covers ::apply
     */
    public function testAppliedToValidUuid()
    {
        $uuid = $this->factory->uuid4();

        $request = Request::create('');
        $request->attributes->set('uuid', $uuid);

        $converter = new ParamConverter(
            [
                'name' => 'uuid',
                'options' => [
                    'uuid' => true
                ]
            ]
        );

        self::assertTrue($this->converter->apply($request, $converter));
        self::assertInstanceOf(
            'Ramsey\Uuid\Uuid',
            $request->attributes->get('uuid')
        );
        self::assertEquals(
            $uuid,
            $request->attributes->get('uuid')->toString()
        );
    }

    /**
     * Verifies that a good configuration is supported.
     *
     * @covers ::supports
     */
    public function testSupportsConfiguration()
    {
        $converter = new ParamConverter(
            [
                'name' => 'uuid'
            ]
        );

        self::assertFalse($this->converter->supports($converter));

        $converter->setOptions(['uuid' => true]);

        self::assertTrue($this->converter->supports($converter));
    }

    /**
     * Sets up the parameter converter.
     */
    protected function setUp()
    {
        $this->factory = new UuidFactory();
        $this->converter = new UuidParamConverter($this->factory);
    }
}
