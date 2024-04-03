<?php

declare(strict_types=1);

namespace Setono\SEOBundle\DataMapper;

use Setono\SEOBundle\Data\PageDataInterface;
use Setono\SEOBundle\Entity\PageInterface;

interface PageDataMapperInterface
{
    /**
     * Maps the given page to the given page data
     */
    public function map(PageInterface $page, PageDataInterface $pageData): void;

    /**
     * Returns true if this mapper is able to map the given page to the given page data
     */
    public function supports(PageInterface $page, PageDataInterface $pageData): bool;
}
