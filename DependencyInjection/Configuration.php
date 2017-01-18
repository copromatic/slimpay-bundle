<?php

namespace SlimpayBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    public function getConfigTreeBuilder() {

        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('slimpay');

        $rootNode
            ->children()
                ->scalarNode('apiUrl')->end()
                ->scalarNode('entryPointUrl')->end()
                ->scalarNode('profile')->end()
                ->scalarNode('tokenEndPointUrl')->end()
                ->scalarNode('creditorReference')->end()
                ->scalarNode('oauthUserId')->end()
                ->scalarNode('oauthPassword')->end()
                ->scalarNode('relNamespace')->end()
            ->end()
        ;

        return $treeBuilder;
    }

}