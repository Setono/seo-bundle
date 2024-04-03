<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Resolver;

use Setono\SEOBundle\Context\ControllerContextInterface;
use Setono\SEOBundle\Data\PageDataInterface;
use Setono\SEOBundle\DataMapper\PageDataMapperInterface;
use Setono\SEOBundle\Factory\PageDataFactoryInterface;
use Setono\SEOBundle\Manager\PageManagerInterface;

// todo rename to PageDataProvider
final class PageDataResolver implements PageDataResolverInterface
{
    public function __construct(
        private readonly ControllerContextInterface $controllerContext,
        private readonly PageManagerInterface $pageManager,
        private readonly PageDataFactoryInterface $pageDataFactory,
        private readonly PageDataMapperInterface $pageDataMapper,
    ) {
    }

    public function getPageData(): PageDataInterface
    {
        $controller = $this->controllerContext->getController();
        $page = $this->pageManager->getFromController($controller);

        $pageData = $this->pageDataFactory->createNew();

        $this->pageDataMapper->map($page, $pageData);

        return $pageData;
    }
}
