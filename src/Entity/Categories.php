<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoriesRepository;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
#[ApiResource]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Annonces::class, orphanRemoval: true)]
    private Collection $annonces;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Annonces>
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonces $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces->add($annonce);
            $annonce->setCategories($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonces $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getCategories() === $this) {
                $annonce->setCategories(null);
            }
        }

        return $this;
    }
}
