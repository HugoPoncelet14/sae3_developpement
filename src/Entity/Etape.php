<?php

namespace App\Entity;

use App\Repository\EtapeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtapeRepository::class)]
class Etape
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $numEtape = null;

    #[ORM\Column(length: 1000)]
    private ?string $descEtape = null;

    #[ORM\ManyToOne(inversedBy: 'etapes')]
    private ?Recette $recette = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumEtape(): ?int
    {
        return $this->numEtape;
    }

    public function setNumEtape(int $numEtape): static
    {
        $this->numEtape = $numEtape;

        return $this;
    }

    public function getDescEtape(): ?string
    {
        return $this->descEtape;
    }

    public function setDescEtape(string $descEtape): static
    {
        $this->descEtape = $descEtape;

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

    public function __toString(): string
    {
        return $this->descEtape;
    }
}
