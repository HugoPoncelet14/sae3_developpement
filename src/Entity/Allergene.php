<?php

namespace App\Entity;

use App\Repository\AllergeneRepository;
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
}