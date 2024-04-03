<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Manager;

use Setono\SEOBundle\Entity\PageInterface;

/**
 * The manager has the responsibility of creating a page (and any child pages) from a controller
 */
interface PageManagerInterface
{
    /**
     * @throws \RuntimeException if it's not possible to return a page from the given controller
     */
    public function getFromController(string $controller): PageInterface;
}
