<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Factory;

use Setono\SEOBundle\Entity\PageInterface;
use Setono\SEOBundle\Resolver\PageNameResolverInterface;

final class PageFactory implements PageFactoryInterface
{
    /**
     * @param class-string<PageInterface> $pageClass
     */
    public function __construct(
        private readonly PageNameResolverInterface $pageNameResolver,
        private readonly string $pageClass,
    ) {
    }

    public function createFromController(string $controller): PageInterface
    {
        /** @var PageInterface $page */
        $page = new $this->pageClass();
        $page->setController($controller)
            ->setName($this->pageNameResolver->getNameFromController($controller))
        ;

        return $page;
    }
}
