<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Factory;

use Setono\SEOBundle\Data\PageDataInterface;

interface PageDataFactoryInterface
{
    public function createNew(): PageDataInterface;
}
