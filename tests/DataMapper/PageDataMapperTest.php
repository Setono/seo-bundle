<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Tests\DataMapper;

use PHPUnit\Framework\TestCase;
use Setono\SEOBundle\Data\PageData;
use Setono\SEOBundle\DataMapper\PageDataMapper;
use Setono\SEOBundle\Entity\Page;

/**
 * @covers \Setono\SEOBundle\DataMapper\PageDataMapper
 */
final class PageDataMapperTest extends TestCase
{
    /**
     * @test
     */
    public function it_maps(): void
    {
        $mapper = new PageDataMapper();
        $page = new Page();
        $page
            ->setNoIndex(true)
            ->setMetaTitle('title')
            ->setMetaDescription('description')
        ;
        $pageData = new PageData();

        $mapper->map($page, $pageData);

        self::assertTrue($pageData->isNoIndex());
        self::assertSame('title', $pageData->getMetaTitle());
        self::assertSame('description', $pageData->getMetaDescription());
    }
}
