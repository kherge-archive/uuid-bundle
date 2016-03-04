<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Manages common functions for service registration.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
 */
abstract class AbstractExtension
{
    /**
     * Registers the service definitions if the required settings are available.
     *
     * @param ContainerBuilder $container The DIC builder.
     * @param array            $config    The bundle settings.
     */
    public function register(ContainerBuilder $container, array $config)
    {
        if ($this->hasSettings($config)) {
            $this->addDefinitions($container, $config);
        }
    }

    /**
     * Adds the service definitions to the DIC.
     *
     * @param ContainerBuilder $container The DIC builder.
     * @param array            $config    The bundle settings.
     */
    abstract protected function addDefinitions(
        ContainerBuilder $container,
        array $config
    );

    /**
     * Checks if the configuration has the required settings.
     *
     * @param array $config The bundle settings.
     */
    abstract protected function hasSettings(array $config);
}
