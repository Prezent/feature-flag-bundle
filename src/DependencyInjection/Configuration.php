<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\DependencyInjection;

use Prezent\FeatureFlagBundle\Handler\ConfigHandler;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('prezent_feature_flag');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('default_permission')
            ->defaultFalse()
            ->end()
            ->scalarNode('handler')
            ->defaultValue(ConfigHandler::class)
            ->end()
            ->end()
            ->append($this->createFeaturesNode())
        ;

        return $treeBuilder;
    }

    /**
     * Create the node for all the features
     */
    private function createFeaturesNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder('features');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('features');
        }

        $rootNode
            ->prototype('array')
            ->treatTrueLike([
                'enabled' => true,
            ])
            ->treatFalseLike([
                'enabled' => false,
            ])
            ->treatNullLike([
                'enabled' => null,
            ])
            ->beforeNormalization()
            ->ifTrue(fn ($value) => is_double($value))
            ->then(fn ($value) => [
                'enabled' => true,
                'ratio' => $value,
            ])
            ->end()
            ->beforeNormalization()
            ->ifTrue(fn ($value) => is_bool($value))
            ->then(fn ($value) => [
                'enabled' => $value,
            ])
            ->end()
            ->beforeNormalization()
            ->ifTrue(fn ($value) => is_string($value) && preg_match('/[0-9]*%/', $value))
            ->then(fn ($value) => [
                'enabled' => true,
                'ratio' => $value / 100,
            ])
            ->end()
            ->children()
            ->booleanNode('enabled')->end()
            ->floatNode('ratio')->end()
            ->end()
            ->end()
        ;

        return $rootNode;
    }
}
