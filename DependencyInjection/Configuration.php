<?php

namespace Prezent\FeatureFlagBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('prezent_feature_flag');

        $rootNode
            ->children()
                ->scalarNode('default_permission')
                    ->defaultFalse()
                ->end()
                ->scalarNode('handler')
                    ->defaultValue('prezent_feature_flag.handler_config')
                ->end()
            ->end()
            ->append($this->createFeaturesNode())
        ;

        return $treeBuilder;
    }

    /**
     * Create the node for all the feartures
     * @return NodeDefinition
     */
    private function createFeaturesNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('features');
        $node
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

        return $node;
    }
}
