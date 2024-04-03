<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Manager;

use Doctrine\Persistence\ManagerRegistry;
use Setono\SEOBundle\Discriminator\DiscriminatorInterface;
use Setono\SEOBundle\Entity\PageInterface;
use Setono\SEOBundle\Factory\PageFactoryInterface;
use Setono\SEOBundle\Repository\PageRepositoryInterface;
use Webmozart\Assert\Assert;

final class PageManager implements PageManagerInterface
{
    public function __construct(
        private readonly DiscriminatorInterface $discriminator,
        private readonly PageRepositoryInterface $pageRepository,
        private readonly PageFactoryInterface $pageFactory,
        private readonly ManagerRegistry $managerRegistry,
    ) {
    }

    public function getFromController(string $controller): PageInterface
    {
        $discriminator = $this->discriminator->getDiscriminator();

        $pages = $this->pageRepository->findByController($controller);
        if ([] === $pages) {
            $page = $this->pageFactory->createFromController($controller);
            $manager = $this->managerRegistry->getManagerForClass($page::class);
            if (null === $manager) {
                throw new \RuntimeException(sprintf('Unable to get manager for class %s', $page::class));
            }

            if (null !== $discriminator) {
                $child = $this->pageFactory->createFromController($controller);
                $child->setDiscriminator($discriminator);

                $page->addChild($child);
            }

            $manager->persist($page);
            $manager->flush();

            return $page;
        }

        $resolvedPage = null;

        foreach ($pages as $page) {
            if ($page->isParent()) {
                $resolvedPage = $page;
            }

            if (null !== $discriminator && $page->getDiscriminator() === $discriminator) {
                $resolvedPage = $page;

                break;
            }
        }

        // this means that we have a discriminator but no page with that discriminator
        if (null !== $resolvedPage && null !== $discriminator && $resolvedPage->isParent()) {
            $child = $this->pageFactory->createFromController($controller);
            $child->setDiscriminator($discriminator);

            $resolvedPage->addChild($child);

            $manager = $this->managerRegistry->getManagerForClass($resolvedPage::class);
            Assert::notNull($manager);

            $manager->flush();

            $resolvedPage = $child;
        }

        if (null === $resolvedPage) {
            throw new \RuntimeException(sprintf('Unable to resolve page for controller %s', $controller));
        }

        return $resolvedPage;
    }
}
