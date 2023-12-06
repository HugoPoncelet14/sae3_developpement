<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomPers = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $pnomPers = null;

    #[ORM\Column(length: 126)]
    private ?string $SHA512PASS = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNais = null;

    #[ORM\Column(length: 50)]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $photoProfil = null;

    #[ORM\ManyToOne(inversedBy: 'personnes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?TypePersonne $typePersonne = null;

    #[ORM\ManyToMany(targetEntity: Allergene::class, inversedBy: 'personnes')]
    private Collection $allergenes;

    public function __construct()
    {
        $this->allergenes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPers(): ?int
    {
        return $this->idPers;
    }

    public function setIdPers(int $idPers): static
    {
        $this->idPers = $idPers;

        return $this;
    }

    public function getIdTpPers(): ?int
    {
        return $this->idTpPers;
    }

    public function setIdTpPers(?int $idTpPers): static
    {
        $this->idTpPers = $idTpPers;

        return $this;
    }

    public function getNomPers(): ?string
    {
        return $this->nomPers;
    }

    public function setNomPers(string $nomPers): static
    {
        $this->nomPers = $nomPers;

        return $this;
    }

    public function getPnomPers(): ?string
    {
        return $this->pnomPers;
    }

    public function setPnomPers(?string $pnomPers): static
    {
        $this->pnomPers = $pnomPers;

        return $this;
    }

    public function getSHA512PASS(): ?string
    {
        return $this->SHA512PASS;
    }

    public function setSHA512PASS(string $SHA512PASS): static
    {
        $this->SHA512PASS = $SHA512PASS;

        return $this;
    }

    public function getDateNais(): ?\DateTimeInterface
    {
        return $this->dateNais;
    }

    public function setDateNais(\DateTimeInterface $dateNais): static
    {
        $this->dateNais = $dateNais;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPhotoProfil()
    {
        return $this->photoProfil;
    }

    public function setPhotoProfil($photoProfil): static
    {
        $this->photoProfil = $photoProfil;

        return $this;
    }

    public function getTypePersonne(): ?TypePersonne
    {
        return $this->typePersonne;
    }

    public function setTypePersonne(?TypePersonne $typePersonne): static
    {
        $this->typePersonne = $typePersonne;

        return $this;
    }

    /**
     * @return Collection<int, allergene>
     */
    public function getAllergenes(): Collection
    {
        return $this->allergenes;
    }

    public function addAllergene(allergene $allergene): static
    {
        if (!$this->allergenes->contains($allergene)) {
            $this->allergenes->add($allergene);
        }

        return $this;
    }

    public function removeAllergene(allergene $allergene): static
    {
        $this->allergenes->removeElement($allergene);

        return $this;
    }
}
