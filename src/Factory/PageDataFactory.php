<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Factory;

use Setono\SEOBundle\Data\PageDataInterface;

final class PageDataFactory implements PageDataFactoryInterface
{
    /**
     * @param class-string<PageDataInterface> $pageDataClass
     */
    public function __construct(private readonly string $pageDataClass)
    {
    }

    public function createNew(): PageDataInterface
    {
        return new $this->pageDataClass();
    }
}
