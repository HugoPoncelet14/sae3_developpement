<?php

namespace App\Entity;

use App\Repository\TypeRecetteRepository;
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
}
