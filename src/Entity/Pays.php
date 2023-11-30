<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaysRepository::class)]
class Pays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomPays = null;

    #[ORM\OneToMany(mappedBy: 'pays', targetEntity: Recette::class)]
    private Collection $recettes;

    #[ORM\OneToMany(mappedBy: 'pays', targetEntity: Region::class)]
    private Collection $regions;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
        $this->regions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPays(): ?int
    {
        return $this->idPays;
    }

    public function setIdPays(int $idPays): static
    {
        $this->idPays = $idPays;

        return $this;
    }

    public function getIdReg(): ?int
    {
        return $this->idReg;
    }

    public function setIdReg(?int $idReg): static
    {
        $this->idReg = $idReg;

        return $this;
    }

    public function getNomPays(): ?string
    {
        return $this->nomPays;
    }

    public function setNomPays(string $nomPays): static
    {
        $this->nomPays = $nomPays;

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
            $recette->setPays($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getPays() === $this) {
                $recette->setPays(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Region>
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): static
    {
        if (!$this->regions->contains($region)) {
            $this->regions->add($region);
            $region->setPays($this);
        }

        return $this;
    }

    public function removeRegion(Region $region): static
    {
        if ($this->regions->removeElement($region)) {
            // set the owning side to null (unless already changed)
            if ($region->getPays() === $this) {
                $region->setPays(null);
            }
        }

        return $this;
    }
}
