<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Factory;

use Setono\SEOBundle\Entity\PageInterface;

interface PageFactoryInterface
{
    public function createFromController(string $controller): PageInterface;
}
