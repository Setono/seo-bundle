<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Tests\DataMapper;

use PHPUnit\Framework\TestCase;
use Setono\SEOBundle\Data\PageData;
use Setono\SEOBundle\DataMapper\TwigBasedPageDataMapper;
use Setono\SEOBundle\Entity\Page;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

final class TwigBasedPageDataMapperTest extends TestCase
{
    /**
     * @test
     */
    public function it_maps(): void
    {
        $twig = new Environment(new ArrayLoader());

        $pageData = new PageData();
        $pageData->metaTitle = 'Hello, {{ name }}! You live in {{ city }}. You are {{ meta.age }} years old. Your email is {{ contact.email }}';

        $contact = new \stdClass();
        $contact->email = 'johndoe@example.com';

        $mapper = new TwigBasedPageDataMapper($twig);
        $mapper->map(new Page(), $pageData, [
            'name' => 'John',
            'city' => 'New York',
            'meta' => ['age' => 30],
            'contact' => $contact,
        ]);

        /** @psalm-suppress TypeDoesNotContainType */
        self::assertSame('Hello, John! You live in New York. You are 30 years old. Your email is johndoe@example.com', $pageData->metaTitle);
    }
}
