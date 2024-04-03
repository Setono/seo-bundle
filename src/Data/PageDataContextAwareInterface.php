<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Data;

interface PageDataContextAwareInterface
{
    public function setContext(array $context): void;
}
