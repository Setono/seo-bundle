<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Provider;

use AutoMapper\AutoMapper;
use AutoMapper\AutoMapperInterface;
use Setono\SEOBundle\Context\ControllerContextInterface;
use Setono\SEOBundle\Data\PageData;
use Setono\SEOBundle\DataMapper\PageDataMapperInterface;
use Setono\SEOBundle\Factory\PageDataFactoryInterface;
use Setono\SEOBundle\Manager\PageManagerInterface;

final readonly class PageDataProvider implements PageDataProviderInterface
{
    public function __construct(
        private ControllerContextInterface $controllerContext,
        private PageManagerInterface $pageManager,
        private PageDataFactoryInterface $pageDataFactory,
        private PageDataMapperInterface $pageDataMapper,
        private ?AutoMapperInterface $automapper = null,
    ) {
    }

    public function getPageData(array $context = []): PageData
    {
        $controller = $this->controllerContext->getController();
        $page = $this->pageManager->getFromController($controller);

        $automapper = $this->automapper ?? AutoMapper::create();
        $exampleContext = $automapper->map($context, 'array') ?? [];
        $page->setExampleContext($exampleContext);

        $pageData = $this->pageDataFactory->createNew();

        $this->pageDataMapper->map($page, $pageData, $context);

        return $pageData;
    }
}
