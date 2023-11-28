<?php

namespace App\Entity;

use App\Repository\TypeRecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRecetteRepository::class)]
class TypeRecette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomTpRec = null;

    #[ORM\OneToMany(mappedBy: 'typeRecette', targetEntity: Recette::class)]
    private Collection $recettes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTpRec(): ?int
    {
        return $this->idTpRec;
    }

    public function setIdTpRec(int $idTpRec): static
    {
        $this->idTpRec = $idTpRec;

        return $this;
    }

    public function getNomTpRec(): ?string
    {
        return $this->nomTpRec;
    }

    public function setNomTpRec(string $nomTpRec): static
    {
        $this->nomTpRec = $nomTpRec;

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
            $recette->setTypeRecette($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getTypeRecette() === $this) {
                $recette->setTypeRecette(null);
            }
        }

        return $this;
    }
}
