<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Page implements PageInterface
{
    protected ?int $id = null;

    protected ?PageInterface $parent = null;

    /** @var Collection<int, PageInterface> */
    protected Collection $children;

    protected ?string $name = null;

    protected ?string $controller = null;

    protected ?string $discriminator = null;

    /** @var list<string>|null */
    protected ?array $exampleUrls = null;

    protected ?array $exampleContext = null;

    protected ?bool $noIndex = null;

    protected ?string $metaTitle = null;

    protected ?string $metaDescription = null;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParent(): ?PageInterface
    {
        return $this->parent;
    }

    public function setParent(?PageInterface $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    public function hasParent(): bool
    {
        return $this->parent !== null;
    }

    public function isRoot(): bool
    {
        return $this->getParent() === null;
    }

    public function addChild(PageInterface $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getController(): ?string
    {
        return $this->controller;
    }

    public function setController(string $controller): static
    {
        $this->controller = $controller;

        return $this;
    }

    public function getDiscriminator(): ?string
    {
        return $this->discriminator;
    }

    public function setDiscriminator(?string $discriminator): static
    {
        $this->discriminator = $discriminator;

        return $this;
    }

    public function getExampleUrls(): ?array
    {
        return $this->exampleUrls;
    }

    /**
     * @param list<string>|null $exampleUrls
     *
     * @return $this
     */
    public function setExampleUrls(?array $exampleUrls): static
    {
        $this->exampleUrls = $exampleUrls;

        return $this;
    }

    public function addExampleUrl(string $url): static
    {
        if (null === $this->exampleUrls) {
            $this->exampleUrls = [];
        }

        $this->exampleUrls[] = $url;
        $this->exampleUrls = array_values(array_unique($this->exampleUrls));

        return $this;
    }

    public function getExampleContext(): ?array
    {
        return $this->exampleContext;
    }

    public function setExampleContext(?array $exampleContext): static
    {
        if ([] === $exampleContext) {
            $exampleContext = null;
        }

        $this->exampleContext = $exampleContext;

        return $this;
    }

    public function isNoIndex(): ?bool
    {
        return $this->noIndex;
    }

    public function setNoIndex(?bool $noIndex): static
    {
        $this->noIndex = $noIndex;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(?string $metaTitle): static
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): static
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }
}
