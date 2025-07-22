<?php

namespace Laminas\I18n\Translator;

use Laminas\ServiceManager\ServiceLocatorInterface;
use Psr\Container\ContainerInterface;

/**
 * Translator.
 *
 * @final
 */
class TranslatorServiceFactory
{
    /**
     * Create a Translator instance.
     *
     * @param string $requestedName
     * @param null|array $options
     * @return Translator
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        // Configure the translator
        $config     = $container->get('config');
        $trConfig   = $config['translator'] ?? [];
        $translator = Translator::factory($trConfig);
        if ($container->has('TranslatorPluginManager')) {
            $translator->setPluginManager($container->get('TranslatorPluginManager'));
        }
        return $translator;
    }

    /**
     * laminas-servicemanager v2 factory for creating Translator instance.
     *
     * @return Translator
     * @deprecated Since 2.16.0 - This component is no longer compatible with Service Manager v2.
     *             This method will be removed in version 3.0
     *
     * Proxies to `__invoke()`.
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, Translator::class);
    }
}
