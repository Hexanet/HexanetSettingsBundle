<?php

namespace Hexanet\SettingsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('hexanet_settings');

        $rootNode
            ->children()
                ->booleanNode('cache')
                    ->defaultValue(false)
                ->end();

        return $treeBuilder;
    }
}
