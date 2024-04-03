<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Twig;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Setono\SEOBundle\Data\PageDataContextAwareInterface;
use Setono\SEOBundle\Data\PageDataInterface;
use Setono\SEOBundle\Provider\PageDataProviderInterface;
use Twig\Extension\RuntimeExtensionInterface;

final class Runtime implements RuntimeExtensionInterface, LoggerAwareInterface
{
    private LoggerInterface $logger;

    public function __construct(private readonly PageDataProviderInterface $pageDataProvider)
    {
        $this->logger = new NullLogger();
    }

    public function noIndex(array $context): bool
    {
        return (bool) $this->get(function (PageDataInterface $pageData) {
            return $pageData->isNoIndex();
        }, $context);
    }

    public function metaTitle(array $context): ?string
    {
        return $this->get(function (PageDataInterface $pageData) {
            return $pageData->getMetaTitle();
        }, $context);
    }

    public function metaDescription(array $context): ?string
    {
        return $this->get(function (PageDataInterface $pageData) {
            return $pageData->getMetaDescription();
        }, $context);
    }

    /**
     * @template T
     *
     * @param callable(PageDataInterface): T $callable
     *
     * @return T|null
     */
    private function get(callable $callable, array $context): mixed
    {
        try {
            $pageData = $this->pageDataProvider->getPageData();
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('Could not resolve page data. Error was: %s', $e->getMessage()));

            return null;
        }

        if ($pageData instanceof PageDataContextAwareInterface) {
            $pageData->setContext($context);
        }

        return $callable($pageData);
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
