<?php

declare(strict_types=1);

namespace Setono\SEOBundle\DependencyInjection;

use Setono\SEOBundle\Data\PageData;
use Setono\SEOBundle\Entity\Page;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('setono_seo');
        $rootNode = $treeBuilder->getRootNode();

        /** @psalm-suppress MixedMethodCall,PossiblyNullReference,UndefinedInterfaceMethod */
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('page')
                            ->info('The page entity')
                            ->defaultValue(Page::class)
                        ->end()
                        ->scalarNode('page_data')
                            ->info('The page data object that holds the data for the page entity on a specific page')
                            ->defaultValue(PageData::class)
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('discriminator')
                    ->info('The name of the discriminator or a service id that implements the discriminator interface. Valid values are "null", "locale", "hostname" or a service id')
                    ->defaultValue('null')
        ;

        return $treeBuilder;
    }
}
