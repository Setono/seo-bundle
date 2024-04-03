<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Resolver;

interface PageNameResolverInterface
{
    public function getNameFromController(string $controller): string;
}
