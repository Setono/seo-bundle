<?php

declare(strict_types=1);

namespace Setono\SEOBundle\DataMapper;

use Setono\SEOBundle\Data\PageData;
use Setono\SEOBundle\Entity\PageInterface;
use Twig\Environment;

final readonly class TwigBasedPageDataMapper implements PageDataMapperInterface
{
    public function __construct(private Environment $twig)
    {
    }

    public function map(PageInterface $page, PageData $pageData, array $context = []): void
    {
        foreach (get_object_vars($pageData) as $property => $value) {
            if (!is_string($value)) {
                continue;
            }

            $template = $this->twig->createTemplate(
                $value,
                sprintf('setono_seo_bundle__page_%d_property_%s', (int) $page->getId(), $property),
            );

            $pageData->{$property} = $this->twig->render($template, $context);
        }
    }
}
