<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class PrezentFeatureFlagExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // load the services file
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        // overwrite the parameters
        $container->setParameter('prezent_feature_flag.default_permission', $config['default_permission']);

        // set the feature flags
        $featureFlags = [];
        foreach ($container->getParameterBag()->all() as $key => $value) {
            if (str_starts_with($key, 'ff_')) {
                $featureFlags[substr($key, 3)] = $value;
            }
        }
        $container->setParameter('prezent_feature_flag.features', $featureFlags);

        // set the alias for the handler we are going to use
        $container->setAlias('prezent_feature_flag.handler', $config['handler']);
    }
}
