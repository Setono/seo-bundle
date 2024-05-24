<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Manager;

use Doctrine\Persistence\ManagerRegistry;
use Setono\Doctrine\ORMTrait;
use Setono\SEOBundle\Discriminator\DiscriminatorInterface;
use Setono\SEOBundle\Entity\PageInterface;
use Setono\SEOBundle\Factory\PageFactoryInterface;
use Setono\SEOBundle\Repository\PageRepositoryInterface;

final class PageManager implements PageManagerInterface
{
    use ORMTrait;

    public function __construct(
        private readonly DiscriminatorInterface $discriminator,
        private readonly PageRepositoryInterface $pageRepository,
        private readonly PageFactoryInterface $pageFactory,
        ManagerRegistry $managerRegistry,
    ) {
        $this->managerRegistry = $managerRegistry;
    }

    public function getFromController(string $controller): PageInterface
    {
        $pages = $this->pageRepository->findByController($controller);
        if ([] === $pages) {
            return $this->createNewPage($controller);
        }

        $discriminator = $this->discriminator->getDiscriminator();

        $resolvedPage = null;

        foreach ($pages as $page) {
            if ($page->isRoot()) {
                $resolvedPage = $page;
            }

            if (null !== $discriminator && $page->getDiscriminator() === $discriminator) {
                $resolvedPage = $page;

                break;
            }
        }

        // this means that we have a discriminator but no page with that discriminator
        if (null !== $resolvedPage && null !== $discriminator && $resolvedPage->isRoot()) {
            $child = $this->createNewChild($controller, $discriminator, $resolvedPage);

            $this->getManager($resolvedPage::class)->flush();

            $resolvedPage = $child;
        }

        if (null === $resolvedPage) {
            throw new \RuntimeException(sprintf('Unable to resolve page for controller %s', $controller));
        }

        return $resolvedPage;
    }

    private function createNewPage(string $controller): PageInterface
    {
        $discriminator = $this->discriminator->getDiscriminator();
        $page = $this->pageFactory->createFromController($controller);
        $manager = $this->getManager($page::class);

        if (null !== $discriminator) {
            $this->createNewChild($controller, $discriminator, $page);
        }

        $manager->persist($page);
        $manager->flush();

        return $page;
    }

    private function createNewChild(string $controller, string $discriminator, PageInterface $parent): PageInterface
    {
        $child = $this->pageFactory->createFromController($controller);
        $child->setDiscriminator($discriminator);

        $parent->addChild($child);

        return $child;
    }
}
