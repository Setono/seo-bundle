<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Resolver;

final class PageNameResolver implements PageNameResolverInterface
{
    public function getNameFromController(string $controller): string
    {
        $parts = explode('::', $controller);
        $class = $parts[0];

        $parts = explode('\\', $class);
        $shortName = end($parts);

        return strtolower(preg_replace('/(Controller|Action)$/', '', $shortName));
    }
}
