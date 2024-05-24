<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Factory;

use Setono\SEOBundle\Entity\PageInterface;
use Setono\SEOBundle\Resolver\PageNameResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class PageFactory implements PageFactoryInterface
{
    /**
     * @param class-string<PageInterface> $pageClass
     */
    public function __construct(
        private RequestStack $requestStack,
        private PageNameResolverInterface $pageNameResolver,
        private string $pageClass,
    ) {
    }

    public function createFromController(string $controller): PageInterface
    {
        /** @var PageInterface $page */
        $page = new $this->pageClass();
        $page->setController($controller)
            ->setName($this->pageNameResolver->getNameFromController($controller))
        ;

        $request = $this->requestStack->getCurrentRequest();
        if (null !== $request) {
            $page->addExampleUrl($request->getUri());
        }

        return $page;
    }
}
