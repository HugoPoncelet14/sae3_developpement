<?php

namespace App\Entity;

use App\Repository\AllergeneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AllergeneRepository::class)]
class Allergene
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomAll = null;

    #[ORM\ManyToMany(targetEntity: Personne::class, mappedBy: 'allergenes')]
    private Collection $personnes;

    #[ORM\OneToMany(mappedBy: 'allergene', targetEntity: Ingrediant::class)]
    private Collection $ingrediants;

    public function __construct()
    {
        $this->personnes = new ArrayCollection();
        $this->ingrediants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAll(): ?string
    {
        return $this->nomAll;
    }

    public function setNomAll(string $nomAll): static
    {
        $this->nomAll = $nomAll;

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
            $personne->addAllergene($this);
        }

        return $this;
    }

    public function removePersonne(Personne $personne): static
    {
        if ($this->personnes->removeElement($personne)) {
            $personne->removeAllergene($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Ingrediant>
     */
    public function getIngrediants(): Collection
    {
        return $this->ingrediants;
    }

    public function addIngrediant(Ingrediant $ingrediant): static
    {
        if (!$this->ingrediants->contains($ingrediant)) {
            $this->ingrediants->add($ingrediant);
            $ingrediant->setAllergene($this);
        }

        return $this;
    }

    public function removeIngrediant(Ingrediant $ingrediant): static
    {
        if ($this->ingrediants->removeElement($ingrediant)) {
            // set the owning side to null (unless already changed)
            if ($ingrediant->getAllergene() === $this) {
                $ingrediant->setAllergene(null);
            }
        }

        return $this;
    }
}
