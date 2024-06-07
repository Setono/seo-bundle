<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Provider;

use Doctrine\Persistence\ManagerRegistry;
use Setono\Doctrine\ORMTrait;
use Setono\SEOBundle\Context\ControllerContextInterface;
use Setono\SEOBundle\Data\PageData;
use Setono\SEOBundle\DataMapper\PageDataMapperInterface;
use Setono\SEOBundle\Factory\PageDataFactoryInterface;
use Setono\SEOBundle\Manager\PageManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class PageDataProvider implements PageDataProviderInterface
{
    use ORMTrait;

    public function __construct(
        private readonly ControllerContextInterface $controllerContext,
        private readonly PageManagerInterface $pageManager,
        private readonly PageDataFactoryInterface $pageDataFactory,
        private readonly PageDataMapperInterface $pageDataMapper,
        private readonly NormalizerInterface $normalizer,
        ManagerRegistry $managerRegistry,
    ) {
        $this->managerRegistry = $managerRegistry;
    }

    public function getPageData(array $context = []): PageData
    {
        $controller = $this->controllerContext->getController();
        $page = $this->pageManager->getFromController($controller);

        if (null === $page->getExampleContext()) {
            $exampleContext = $this->normalizer->normalize($context, null, [AbstractNormalizer::CIRCULAR_REFERENCE_LIMIT => 10]);
            if (is_array($exampleContext)) {
                $page->setExampleContext($exampleContext);
            }

            $this->getManager($page::class)->flush();
        }

        $pageData = $this->pageDataFactory->createNew();

        $this->pageDataMapper->map($page, $pageData, $context);

        return $pageData;
    }
}
