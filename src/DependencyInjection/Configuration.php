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
                            ->info('The class that implements the page interface')
                            ->defaultValue(Page::class)
                        ->end()
                        ->scalarNode('page_data')
                            ->info('The class that implements the page data interface')
                            ->defaultValue(PageData::class)
                        ->end()

                    ->end()
                ->end()
                ->scalarNode('discriminator')
                    ->info('The name of the discriminator or a service id that implements the discriminator interface')
                    ->defaultValue('null')
        ;

        return $treeBuilder;
    }
}
