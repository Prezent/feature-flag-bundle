<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('prezent_feature_flag');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('prezent_feature_flag');
        }

        $rootNode
            ->children()
                ->scalarNode('default_permission')
                    ->defaultFalse()
                ->end()
                ->scalarNode('handler')
                    ->defaultValue('Prezent\FeatureFlagBundle\Handler\ConfigHandler')
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
                ->treatTrueLike(['enabled' => true])
                ->treatFalseLike(['enabled' => false])
                ->treatNullLike(['enabled' => null])
                ->beforeNormalization()
                    ->ifTrue(function ($value) { return is_double($value); })
                    ->then(function ($value) { return ['enabled' => true, 'ratio' => $value]; })
                ->end()
                ->beforeNormalization()
                    ->ifTrue(function ($value) { return is_bool($value); })
                    ->then(function ($value) { return ['enabled' => $value]; })
                ->end()
                ->beforeNormalization()
                    ->ifTrue(function ($value) { return is_string($value) && preg_match('/[0-9]*%/', $value); })
                    ->then(function ($value) { return ['enabled' => true, 'ratio' => $value / 100]; })
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
