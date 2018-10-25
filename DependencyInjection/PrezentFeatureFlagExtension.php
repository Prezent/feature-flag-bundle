<?php

namespace Prezent\FeatureFlagBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PrezentFeatureFlagExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // load the services file
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        // overwrite the parameters
        $container->setParameter('prezent_feature_flag.default_permission', $config['default_permission']);

        if ($container->hasParameter('feature_flags')) {
            $container->setParameter('prezent_feature_flag.features', $container->getParameter('feature_flags'));
        }

        // set the alias for the handler we are going to use
        $container->setAlias('prezent_feature_flag.handler', $config['handler']);
    }
}
