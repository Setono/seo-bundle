<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Provider;

use Setono\SEOBundle\Data\PageData;

interface PageDataProviderInterface
{
    public function getPageData(array $context = []): PageData;
}
