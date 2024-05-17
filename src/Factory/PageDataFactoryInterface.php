<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Factory;

use Setono\SEOBundle\Data\PageData;

/**
 * @template T of PageData
 */
interface PageDataFactoryInterface
{
    /**
     * @return T
     */
    public function createNew(): PageData;
}
