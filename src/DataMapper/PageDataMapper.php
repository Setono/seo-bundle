<?php

declare(strict_types=1);

namespace Setono\SEOBundle\DataMapper;

use AutoMapper\AutoMapper;
use AutoMapper\AutoMapperInterface;
use Setono\SEOBundle\Data\PageData;
use Setono\SEOBundle\Entity\PageInterface;

final readonly class PageDataMapper implements PageDataMapperInterface
{
    public function __construct(private ?AutoMapperInterface $automapper = null)
    {
    }

    public function map(PageInterface $page, PageData $pageData, array $context = []): void
    {
        $automapper = $this->automapper ?? AutoMapper::create();

        $unsetProperties = array_keys(array_filter(get_object_vars($pageData), static fn (mixed $value) => null === $value));

        do {
            $automapper->map($page, $pageData, [
                'allowed_attributes' => $unsetProperties,
                'skip_null_values' => true,
            ]);

            foreach ($unsetProperties as $key => $property) {
                if (null !== $pageData->{$property}) {
                    unset($unsetProperties[$key]);
                }
            }

            $page = $page->getParent();
        } while ([] !== $unsetProperties && null !== $page);
    }
}
