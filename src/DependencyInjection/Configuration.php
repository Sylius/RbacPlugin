<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\DependencyInjection;

use Sylius\RbacPlugin\Access\Model\Section;
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
                        ->arrayNode(Section::CATALOG)->variablePrototype()->end()->end()
                        ->arrayNode(Section::CONFIGURATION)->variablePrototype()->end()->end()
                        ->arrayNode(Section::CUSTOMERS)->variablePrototype()->end()->end()
                        ->arrayNode(Section::MARKETING)->variablePrototype()->end()->end()
                        ->arrayNode(Section::SALES)->variablePrototype()->end()->end()
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
