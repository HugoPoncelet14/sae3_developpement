<?php

namespace App\Entity;

use App\Repository\UstensileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UstensileRepository::class)]
class Ustensile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    #[ORM\Column(length: 40)]
    private ?string $name = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imgUst;

    #[ORM\ManyToMany(targetEntity: Recette::class, mappedBy: 'ustensiles')]
    private Collection $recettes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImgUst()
    {
        return $this->imgUst;
    }

    public function setImgUst($imgUst): static
    {
        $this->imgUst = $imgUst;

        return $this;
    }

    /**
     * @return Collection<int, Recette>
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recette $recette): static
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
            $recette->addUstensile($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            $recette->removeUstensile($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
