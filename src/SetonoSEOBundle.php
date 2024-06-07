<?php

declare(strict_types=1);

namespace Setono\SEOBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Setono\CompositeCompilerPass\CompositeCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SetonoSEOBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CompositeCompilerPass(
            'setono_seo.data_mapper.composite',
            'setono_seo.data_mapper',
        ));

        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver(
            [__DIR__ . '/../config/doctrine-mapping' => 'Setono\SEOBundle\Entity'],
        ));
    }
}
