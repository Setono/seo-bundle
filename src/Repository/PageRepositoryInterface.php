<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Repository;

use Setono\SEOBundle\Entity\Page;

interface PageRepositoryInterface
{
    /**
     * @return list<Page>
     */
    public function findByController(string $controller): array;
}
