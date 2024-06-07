<?php

declare(strict_types=1);

namespace Setono\SEOBundle\DataMapper;

use Setono\CompositeCompilerPass\CompositeService;
use Setono\SEOBundle\Data\PageData;
use Setono\SEOBundle\Entity\PageInterface;

/**
 * @extends CompositeService<PageDataMapperInterface>
 */
final class CompositeDataMapper extends CompositeService implements PageDataMapperInterface
{
    public function map(PageInterface $page, PageData $pageData, array $context = []): void
    {
        foreach ($this->services as $service) {
            $service->map($page, $pageData, $context);
        }
    }
}
