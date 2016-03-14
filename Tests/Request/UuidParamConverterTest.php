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
     *
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage The identifier "test" is not valid.
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

        $request->attributes->set('uuid', 'test');

        $this->converter->apply($request, $converter);
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

        $configuration = new ParamConverter(
            [
                'name' => 'uuid',
                'options' => [
                    'uuid' => true
                ]
            ]
        );

        self::assertTrue($this->converter->apply($request, $configuration));
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
        $configuration = new ParamConverter(
            [
                'name' => 'uuid'
            ]
        );

        self::assertFalse($this->converter->supports($configuration));

        $configuration->setClass('Ramsey\Uuid\Uuid');

        self::assertTrue($this->converter->supports($configuration));
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
