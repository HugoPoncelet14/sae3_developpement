<?php

namespace App\Entity;

use App\Repository\TypePersonneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypePersonneRepository::class)]
class TypePersonne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idTpPers = null;

    #[ORM\Column(length: 50)]
    private ?string $nomTpPers = null;

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
}
