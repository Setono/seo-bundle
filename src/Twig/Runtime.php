<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Twig;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Setono\SEOBundle\Data\PageData;
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
        return (bool) $this->get(function (PageData $pageData) {
            return $pageData->noIndex;
        }, $context);
    }

    public function noIndexTag(array $context): string
    {
        if ($this->noIndex($context)) {
            return '<meta name="robots" content="noindex">';
        }

        return '';
    }

    public function metaTitle(array $context, string $default = null): ?string
    {
        return $this->get(fn (PageData $pageData) => $pageData->metaTitle ?? $default, $context);
    }

    public function metaTitleTag(array $context, string $default = null): string
    {
        $title = $this->metaTitle($context, $default);
        if (null === $title || '' === $title) {
            return '';
        }

        return sprintf('<title>%s</title>', $title);
    }

    public function metaDescription(array $context): ?string
    {
        return $this->get(function (PageData $pageData) {
            return $pageData->metaDescription;
        }, $context);
    }

    public function metaDescriptionTag(array $context): string
    {
        $metaDescription = $this->metaDescription($context);
        if (null === $metaDescription || '' === $metaDescription) {
            return '';
        }

        return sprintf('<meta name="description" content="%s">', $metaDescription);
    }

    /**
     * @template T
     *
     * @param callable(PageData): T $callable
     *
     * @return T|null
     */
    private function get(callable $callable, array $context): mixed
    {
        try {
            $pageData = $this->pageDataProvider->getPageData($context);
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('Could not resolve page data. Error was: %s', $e->getMessage()));

            return null;
        }

        return $callable($pageData);
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
