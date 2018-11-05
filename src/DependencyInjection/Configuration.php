<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sylius_rbac');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('section_routes_prefixes')
                    ->children()
                        ->variableNode('catalog')->end()
                        ->variableNode('configuration')->end()
                        ->variableNode('customers')->end()
                        ->variableNode('marketing')->end()
                        ->variableNode('sales')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
