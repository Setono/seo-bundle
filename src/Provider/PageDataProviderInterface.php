<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Provider;

use Setono\SEOBundle\Data\PageDataInterface;

interface PageDataProviderInterface
{
    public function getPageData(): PageDataInterface;
}
