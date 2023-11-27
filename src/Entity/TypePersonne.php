<?php

namespace App\Entity;

use App\Repository\TypePersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypePersonneRepository::class)]
class TypePersonne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomTpPers = null;

    #[ORM\OneToMany(mappedBy: 'typePersonne', targetEntity: Personne::class)]
    private Collection $personnes;

    public function __construct()
    {
        $this->personnes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTpPers(): ?int
    {
        return $this->idTpPers;
    }

    public function setIdTpPers(int $idTpPers): static
    {
        $this->idTpPers = $idTpPers;

        return $this;
    }

    public function getNomTpPers(): ?string
    {
        return $this->nomTpPers;
    }

    public function setNomTpPers(string $nomTpPers): static
    {
        $this->nomTpPers = $nomTpPers;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getPersonnes(): Collection
    {
        return $this->personnes;
    }

    public function addPersonne(Personne $personne): static
    {
        if (!$this->personnes->contains($personne)) {
            $this->personnes->add($personne);
            $personne->setTypePersonne($this);
        }

        return $this;
    }

    public function removePersonne(Personne $personne): static
    {
        if ($this->personnes->removeElement($personne)) {
            // set the owning side to null (unless already changed)
            if ($personne->getTypePersonne() === $this) {
                $personne->setTypePersonne(null);
            }
        }

        return $this;
    }
}
