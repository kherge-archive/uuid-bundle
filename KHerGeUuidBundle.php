<?php

namespace KHerGe\Bundle\UuidBundle;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Registers the bundle with the application kernel.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class KHerGeUuidBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        /*
         * Set the factory for the `Uuid` singleton.
         *
         * This will allow you to make calls directly to `Uuid` static methods
         * (`uuid1`, `uuid2`, etc.) without using the factory class directly.
         * This type of usage is not recommended as it can make testing more
         * difficult.
         */
        if ($this->container->getParameter('kherge_uuid.uuid_factory.global')) {
            Uuid::setFactory($this->container->get('kherge_uuid.uuid_factory'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = $this->createContainerExtension();
        }

        return $this->extension;
    }
}
