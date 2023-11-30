<?php

namespace App\Entity;

use App\Repository\QuantiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuantiteRepository::class)]
class Quantite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $quantite = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $unitMesure = null;

    #[ORM\ManyToOne(inversedBy: 'quantites')]
    private ?Recette $recette = null;

    #[ORM\ManyToOne(inversedBy: 'quantites')]
    private ?Ingrediant $ingrediant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getUnitMesure(): ?string
    {
        return $this->unitMesure;
    }

    public function setUnitMesure(string $unitMesure): static
    {
        $this->unitMesure = $unitMesure;

        return $this;
    }

    public function getRecette(): ?Recette
    {
        return $this->recette;
    }

    public function setRecette(?Recette $recette): static
    {
        $this->recette = $recette;

        return $this;
    }

    public function getIngrediant(): ?Ingrediant
    {
        return $this->ingrediant;
    }

    public function setIngrediant(?Ingrediant $ingrediant): static
    {
        $this->ingrediant = $ingrediant;

        return $this;
    }
}
