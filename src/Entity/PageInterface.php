<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Entity;

use Doctrine\Common\Collections\Collection;

interface PageInterface
{
    public function getId(): ?int;

    /**
     * @return Collection<int, PageInterface>
     */
    public function getChildren(): Collection;

    /**
     * A page can have children, distinguished by the discriminator
     */
    public function addChild(self $child): static;

    public function getParent(): ?self;

    public function setParent(?self $parent): static;

    /**
     * Returns true if the page has a parent
     */
    public function hasParent(): bool;

    /**
     * Returns true if the page is a root page
     */
    public function isRoot(): bool;

    public function getName(): ?string;

    /**
     * Sets the name of the page. You can use this as a reference
     */
    public function setName(string $name): static;

    public function getController(): ?string;

    /**
     * The controller that renders the page
     */
    public function setController(string $controller): static;

    public function getDiscriminator(): ?string;

    /**
     * The discriminator is used to differentiate between child pages with the same controller.
     *
     * A common use case is when you have a page in multiple languages. Then you can use the discriminator to distinguish between e.g. the English and the German page.
     */
    public function setDiscriminator(?string $discriminator): static;

    public function getExampleUrls(): ?array;

    /**
     * @param list<string>|null $exampleUrls
     */
    public function setExampleUrls(?array $exampleUrls): static;

    public function addExampleUrl(string $url): static;

    public function getExampleContext(): ?array;

    public function setExampleContext(?array $exampleContext): static;
}
