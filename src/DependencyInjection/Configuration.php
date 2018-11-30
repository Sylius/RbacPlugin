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
                ->arrayNode('sylius_sections')
                    ->children()
                        ->arrayNode('catalog')->variablePrototype()->end()->end()
                        ->arrayNode('configuration')->variablePrototype()->end()->end()
                        ->arrayNode('customers')->variablePrototype()->end()->end()
                        ->arrayNode('marketing')->variablePrototype()->end()->end()
                        ->arrayNode('sales')->variablePrototype()->end()->end()
                    ->end()
                ->end()
            ->end()
            ->children()
                /* it's a very MVP approach, as now we can pass almost everything there
                   TODO: create some more strict custom sections structure */
                ->arrayNode('custom_sections')
                    ->useAttributeAsKey('name')
                    ->variablePrototype()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
