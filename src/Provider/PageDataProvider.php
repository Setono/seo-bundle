<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Provider;

use Setono\SEOBundle\Context\ControllerContextInterface;
use Setono\SEOBundle\Data\PageData;
use Setono\SEOBundle\DataMapper\PageDataMapperInterface;
use Setono\SEOBundle\Factory\PageDataFactoryInterface;
use Setono\SEOBundle\Manager\PageManagerInterface;

final class PageDataProvider implements PageDataProviderInterface
{
    public function __construct(
        private readonly ControllerContextInterface $controllerContext,
        private readonly PageManagerInterface $pageManager,
        private readonly PageDataFactoryInterface $pageDataFactory,
        private readonly PageDataMapperInterface $pageDataMapper,
    ) {
    }

    public function getPageData(array $context = []): PageData
    {
        $controller = $this->controllerContext->getController();
        $page = $this->pageManager->getFromController($controller);

        $pageData = $this->pageDataFactory->createNew();

        $this->pageDataMapper->map($page, $pageData, $context);

        return $pageData;
    }
}
