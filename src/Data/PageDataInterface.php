<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Data;

interface PageDataInterface
{
    /**
     * Returns true if the page should be noindexed
     */
    public function isNoIndex(): bool;

    /**
     * The string to use as the title of the page, i.e. <title>
     */
    public function getMetaTitle(): ?string;

    public function getMetaDescription(): ?string;
}
