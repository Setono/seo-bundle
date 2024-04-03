<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Discriminator;

use Symfony\Component\HttpFoundation\RequestStack;

final class HostnameDiscriminator implements DiscriminatorInterface
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function getDiscriminator(): ?string
    {
        return $this->requestStack->getMainRequest()?->getHost();
    }
}
