<?php

namespace App\Entity;

use App\Repository\IngrediantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngrediantRepository::class)]
class Ingrediant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomIng = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomIng(): ?string
    {
        return $this->nomIng;
    }

    public function setNomIng(string $nomIng): static
    {
        $this->nomIng = $nomIng;

        return $this;
    }
}
