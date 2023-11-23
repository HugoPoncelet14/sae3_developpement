<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomRec = null;

    #[ORM\Column(length: 250)]
    private ?string $descRec = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imgRec = null;

    #[ORM\Column]
    private ?int $tpsDePrep = null;

    #[ORM\Column]
    private ?float $nbrCallo = null;

    #[ORM\Column]
    private ?int $nbrPers = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRec(): ?int
    {
        return $this->idRec;
    }

    public function setIdRec(int $idRec): static
    {
        $this->idRec = $idRec;

        return $this;
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

    public function getIdPays(): ?int
    {
        return $this->idPays;
    }

    public function setIdPays(int $idPays): static
    {
        $this->idPays = $idPays;

        return $this;
    }

    public function getNomRec(): ?string
    {
        return $this->nomRec;
    }

    public function setNomRec(string $nomRec): static
    {
        $this->nomRec = $nomRec;

        return $this;
    }

    public function getDescRec(): ?string
    {
        return $this->descRec;
    }

    public function setDescRec(string $descRec): static
    {
        $this->descRec = $descRec;

        return $this;
    }

    public function getImgRec()
    {
        return $this->imgRec;
    }

    public function setImgRec($imgRec): static
    {
        $this->imgRec = $imgRec;

        return $this;
    }

    public function getTpsDePrep(): ?int
    {
        return $this->tpsDePrep;
    }

    public function setTpsDePrep(int $tpsDePrep): static
    {
        $this->tpsDePrep = $tpsDePrep;

        return $this;
    }

    public function getNbrCallo(): ?float
    {
        return $this->nbrCallo;
    }

    public function setNbrCallo(float $nbrCallo): static
    {
        $this->nbrCallo = $nbrCallo;

        return $this;
    }

    public function getNbrPers(): ?int
    {
        return $this->nbrPers;
    }

    public function setNbrPers(int $nbrPers): static
    {
        $this->nbrPers = $nbrPers;

        return $this;
    }
}
