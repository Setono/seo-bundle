<?php

declare(strict_types=1);

namespace Setono\SEOBundle\DependencyInjection;

use Setono\SEOBundle\DataMapper\PageDataMapperInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoSEOExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        /**
         * @psalm-suppress PossiblyNullArgument
         *
         * @var array{discriminator: string, classes: array{page: string, page_data: string}} $config
         */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        if (in_array($config['discriminator'], ['null', 'locale', 'hostname'], true)) {
            $config['discriminator'] = str_replace(
                ['null', 'locale', 'hostname'],
                ['setono_seo.discriminator.null', 'setono_seo.discriminator.locale', 'setono_seo.discriminator.hostname'],
                $config['discriminator'],
            );
        }

        $container->setAlias('setono_seo.discriminator.default', $config['discriminator']);

        $container->setParameter('setono_seo.page.class', $config['classes']['page']);
        $container->setParameter('setono_seo.page_data.class', $config['classes']['page_data']);

        $container->registerForAutoconfiguration(PageDataMapperInterface::class)
            ->addTag('setono_seo.data_mapper')
        ;

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.xml');
    }
}
