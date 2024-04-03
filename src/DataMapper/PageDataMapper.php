<?php

declare(strict_types=1);

namespace Setono\SEOBundle\DataMapper;

use Setono\SEOBundle\Data\PageData;
use Setono\SEOBundle\Data\PageDataInterface;
use Setono\SEOBundle\Entity\Page;
use Setono\SEOBundle\Entity\PageInterface;
use Webmozart\Assert\Assert;

final class PageDataMapper implements PageDataMapperInterface
{
    /**
     * @param Page|PageInterface $page
     * @param PageData|PageDataInterface $pageData
     */
    public function map(PageInterface $page, PageDataInterface $pageData): void
    {
        Assert::true($this->supports($page, $pageData));

        /** @var array<string, mixed> $properties */
        $properties = [];

        $reflectionClass = new \ReflectionClass($page::class);
        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            if (
                0 !== $reflectionMethod->getNumberOfRequiredParameters() ||
                $reflectionMethod->isStatic() ||
                $reflectionMethod->isConstructor() ||
                $reflectionMethod->isDestructor()
            ) {
                continue;
            }

            $name = $reflectionMethod->name;
            $property = null;

            if (str_starts_with($name, 'get') || str_starts_with($name, 'has')) {
                // getters and hassers
                $property = lcfirst(substr($name, 3));
            } elseif (str_starts_with($name, 'is')) {
                // issers
                $property = lcfirst(substr($name, 2));
            }

            if (null !== $property) {
                /** @psalm-suppress MixedAssignment */
                $properties[$property] = $page->{$name}();
            }
        }

        /** @var mixed $value */
        foreach ($properties as $property => $value) {
            $setter = 'set' . ucfirst($property);
            if (!method_exists($pageData, $setter) || !is_callable([$pageData, $setter]) || (new \ReflectionMethod($pageData, $setter))->isStatic()) {
                continue;
            }

            $pageData->{$setter}($value);
        }
    }

    /**
     * @psalm-assert-if-true Page $page
     * @psalm-assert-if-true PageData $pageData
     */
    public function supports(PageInterface $page, PageDataInterface $pageData): bool
    {
        return $page instanceof Page && $pageData instanceof PageData;
    }
}
