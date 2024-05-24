<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\SEOBundle\Data\PageData;
use Setono\SEOBundle\DependencyInjection\SetonoSEOExtension;
use Setono\SEOBundle\Entity\Page;

final class SetonoSEOExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new SetonoSEOExtension(),
        ];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameter_has_been_set(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('setono_seo.page.class', Page::class);
        $this->assertContainerBuilderHasParameter('setono_seo.page_data.class', PageData::class);
        $this->assertContainerBuilderHasAlias('setono_seo.discriminator.default', 'setono_seo.discriminator.null');
    }
}
