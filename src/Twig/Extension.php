<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class Extension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('no_index', [Runtime::class, 'noIndex'], ['needs_context' => true]),
            new TwigFunction('no_index_tag', [Runtime::class, 'noIndexTag'], ['needs_context' => true, 'is_safe' => ['html']]),

            new TwigFunction('meta_title', [Runtime::class, 'metaTitle'], ['needs_context' => true]),
            new TwigFunction('meta_title_tag', [Runtime::class, 'metaTitleTag'], ['needs_context' => true, 'is_safe' => ['html']]),

            new TwigFunction('meta_description', [Runtime::class, 'metaDescription'], ['needs_context' => true]),
            new TwigFunction('meta_description_tag', [Runtime::class, 'metaDescriptionTag'], ['needs_context' => true, 'is_safe' => ['html']]),
        ];
    }
}
