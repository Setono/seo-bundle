<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Factory;

use Setono\SEOBundle\Data\PageData;

/**
 * @implements PageDataFactoryInterface<PageData>
 */
final class PageDataFactory implements PageDataFactoryInterface
{
    /**
     * @param class-string<PageData> $pageDataClass
     */
    public function __construct(private readonly string $pageDataClass)
    {
    }

    public function createNew(): PageData
    {
        /**
         * If you decide to use a constructor for the PageData class, you should override this method
         * and pass the necessary arguments to the constructor.
         *
         * @psalm-suppress UnsafeInstantiation
         */
        return new $this->pageDataClass();
    }
}
