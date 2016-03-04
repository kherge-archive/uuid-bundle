<?php

namespace KHerGe\Bundle\UuidBundle\DependencyInjection;

use KHerGe\Bundle\UuidBundle\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Registers parameters and services based on the bundle settings.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class KHerGeUuidExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function getAlias()
    {
        return 'kherge_uuid';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(
            new Configuration(),
            $configs
        );

        $this->register($container, $config, 'Builder');
        $this->register($container, $config, 'Codec');
        $this->register($container, $config, 'Converter/Number');
        $this->register($container, $config, 'Converter/Time');
        $this->register($container, $config, 'Generator');
        $this->register($container, $config, 'Provider/Node');
        $this->register($container, $config, 'Provider/Time');
        $this->register($container, $config, '');
    }

    /**
     * Registers a directory of classes with the DIC.
     *
     * @param ContainerBuilder $container The DIC builder.
     * @param array            $config    The bundle settings.
     * @param string           $dir       The name of the directory of classes.
     */
    private function register(
        ContainerBuilder $container,
        array $config,
        $dir
    ) {
        if (empty($dir)) {
            $path = __DIR__ . DIRECTORY_SEPARATOR . 'Extension';
        } else {
            $path = sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'Extension',
                DIRECTORY_SEPARATOR,
                $dir
            );
        }

        foreach (scandir($path) as $class) {
            if (false !== strpos($class, 'AbstractExtension')) {
                continue;
            }

            $file = $path . DIRECTORY_SEPARATOR . $class;

            if (empty($dir)) {
                $class = sprintf(
                    '%s\Extension\%s',
                    __NAMESPACE__,
                    explode('.', $class)[0]
                );
            } else {
                $class = sprintf(
                    '%s\Extension\%s\%s',
                    __NAMESPACE__,
                    str_replace('/', '\\', $dir),
                    explode('.', $class)[0]
                );
            }

            if (is_file($file)) {
                /** @var AbstractExtension $instance */
                $instance = new $class();
                $instance->register($container, $config);
            }
        }
    }
}
