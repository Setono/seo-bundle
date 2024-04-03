<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Resolver;

use Setono\SEOBundle\Data\PageDataInterface;

interface PageDataResolverInterface
{
    public function getPageData(): PageDataInterface;
}
