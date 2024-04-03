<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Discriminator;

interface DiscriminatorInterface
{
    public function getDiscriminator(): ?string;
}
