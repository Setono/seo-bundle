<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Context;

use Setono\SEOBundle\Data\PageDataInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class RequestAttributeBasedPageDataContext implements PageDataContextInterface
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function getPageData(): PageDataInterface
    {
        /** @var mixed $pageData */
        $pageData = $this->requestStack->getMainRequest()?->attributes->get('_page_data');

        if (!$pageData instanceof PageDataInterface) {
            throw new \RuntimeException('Unable to get the page data');
        }

        return $pageData;
    }
}
