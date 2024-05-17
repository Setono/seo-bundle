<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Tests\Resolver;

use PHPUnit\Framework\TestCase;
use Setono\SEOBundle\Resolver\PageNameResolver;

final class PageNameResolverTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider provideControllers
     */
    public function it_resolves(string $controller, string $expected): void
    {
        self::assertSame($expected, (new PageNameResolver())->getNameFromController($controller));
    }

    /**
     * @return \Generator<array-key, array{string, string}>
     */
    public function provideControllers(): \Generator
    {
        yield ['App\\Controller\\HomeController::index', 'Home Index'];
        yield ['App\\Controller\\HomeController::indexAction', 'Home Index'];
        yield ['App\\Controller\\ProductController::show', 'Product Show'];
        yield ['App\\Controller\\ProductController::showEnabled', 'Product Show Enabled'];
        yield ['App\\Controller\\GetProductsAction::__invoke', 'Get Products'];
    }
}
