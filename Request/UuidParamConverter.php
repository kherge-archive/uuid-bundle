<?php

namespace KHerGe\Bundle\UuidBundle\Request;

use InvalidArgumentException;
use Ramsey\Uuid\UuidFactoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

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

        if (null === $uuid) {
            return false;
        }

        try {
            $request->attributes->set($name, $this->factory->fromString($uuid));

            return true;
        } catch (InvalidArgumentException $exception) {
            // Intentionally do nothing.
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        $options = $configuration->getOptions();

        return (isset($options['uuid']) && (true === $options['uuid']));
    }
}
