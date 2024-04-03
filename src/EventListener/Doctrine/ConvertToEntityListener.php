<?php

declare(strict_types=1);

namespace Setono\SEOBundle\EventListener\Doctrine;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\Event\LoadClassMetadataEventArgs;
use Setono\SEOBundle\Entity\Page;

/**
 * If the user of the bundle doesn't add their own Page entity,
 * this listener will make sure that Doctrine sees our Page as an entity (instead of a mapped superclass
 */
final class ConvertToEntityListener
{
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        if (!is_a($eventArgs->getClassMetadata()->getName(), Page::class, true)) {
            return;
        }

        $metadata = $eventArgs->getClassMetadata();
        if (!$metadata instanceof ClassMetadata) {
            return;
        }

        $metadata->isMappedSuperclass = false;
    }
}
