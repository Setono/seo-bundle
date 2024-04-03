<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Setono\SEOBundle\Entity\Page;

/**
 * @extends ServiceEntityRepository<Page>
 */
class PageRepository extends ServiceEntityRepository implements PageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function findByController(string $controller): array
    {
        return $this->findBy(['controller' => $controller]);
    }
}
