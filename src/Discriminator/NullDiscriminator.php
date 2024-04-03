<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Discriminator;

final class NullDiscriminator implements DiscriminatorInterface
{
    public function getDiscriminator(): ?string
    {
        return null;
    }
}
