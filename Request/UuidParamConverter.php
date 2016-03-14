<?php

namespace KHerGe\Bundle\UuidBundle\Request;

use InvalidArgumentException;
use Ramsey\Uuid\UuidFactoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Converts a UUID request parameter into a `Uuid` instance.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class UuidParamConverter implements ParamConverterInterface
{
    /**
     * The UUID factory.
     *
     * @var UuidFactoryInterface
     */
    private $factory;

    /**
     * Sets the UUID factory.
     *
     * @param UuidFactoryInterface $factory The UUID factory.
     */
    public function __construct(UuidFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $name = $configuration->getName();
        $uuid = $request->attributes->get($name, null);

        try {
            $request->attributes->set($name, $this->factory->fromString($uuid));

            return true;
        } catch (InvalidArgumentException $exception) {
            throw new NotFoundHttpException(
                sprintf(
                    'The identifier "%s" is not valid.',
                    $uuid
                )
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        return ('Ramsey\Uuid\Uuid' === $configuration->getClass());
    }
}
