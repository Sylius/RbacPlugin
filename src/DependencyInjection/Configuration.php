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
                ->arrayNode('sylius_section_routes_prefixes')
                    ->children()
                        ->variableNode('catalog')->end()
                        ->variableNode('configuration')->end()
                        ->variableNode('customers')->end()
                        ->variableNode('marketing')->end()
                        ->variableNode('sales')->end()
                    ->end()
                ->end()
                /* it's a very MVP approach, as now we can pass almost everything there
                   TODO: create some more strict custom sections structure */
                ->variableNode('custom_section_routes_prefixes')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
