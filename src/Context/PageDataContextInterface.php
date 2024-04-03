<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Context;

use Setono\SEOBundle\Data\PageDataInterface;

interface PageDataContextInterface
{
    /**
     * @throws \RuntimeException if it's not possible to get the page data
     */
    public function getPageData(): PageDataInterface;
}
