<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Resolver;

use function Symfony\Component\String\u;

final class PageNameResolver implements PageNameResolverInterface
{
    public function getNameFromController(string $controller): string
    {
        $controllerParts = explode('::', $controller);
        $class = $controllerParts[0];
        $action = $controllerParts[1] ?? '';

        $classParts = explode('\\', $class);
        $class = u(end($classParts))
            ->trimSuffix(['Controller', 'Action'])
            ->snake()
            ->replace('_', ' ')
            ->title(true)
            ->toString()
        ;

        if ('' !== $action && '__invoke' !== $action) {
            $action = u($action)
                ->trimSuffix('Action')
                ->snake()
                ->replace('_', ' ')
                ->title(true)
                ->toString()
            ;

            return $class . ' ' . $action;
        }

        return $class;
    }
}
