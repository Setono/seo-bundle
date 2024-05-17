<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Data;

/**
 * All properties MUST be null by default. This allows the data mapper to know which properties have been set
 */
class PageData
{
    public ?bool $noIndex = null;

    public ?string $metaTitle = null;

    public ?string $metaDescription = null;
}
