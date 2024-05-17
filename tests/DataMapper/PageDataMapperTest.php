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

        $child = new Page();
        $child
            ->setMetaTitle('title')
            ->setMetaDescription('description')
        ;

        $parent = new Page();
        $parent->setNoIndex(true);
        $parent->addChild($child);

        $pageData = new PageData();

        $mapper->map($child, $pageData);

        self::assertTrue($pageData->noIndex);
        self::assertSame('title', $pageData->metaTitle);
        self::assertSame('description', $pageData->metaDescription);
    }
}
