<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomReg = null;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: Pays::class)]
    private Collection $pays;

    public function __construct()
    {
        $this->pays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdReg(): ?int
    {
        return $this->idReg;
    }

    public function setIdReg(int $idReg): static
    {
        $this->idReg = $idReg;

        return $this;
    }

    public function getNomReg(): ?string
    {
        return $this->nomReg;
    }

    public function setNomReg(string $nomReg): static
    {
        $this->nomReg = $nomReg;

        return $this;
    }

    /**
     * @return Collection<int, Pays>
     */
    public function getPays(): Collection
    {
        return $this->pays;
    }

    public function addPay(Pays $pay): static
    {
        if (!$this->pays->contains($pay)) {
            $this->pays->add($pay);
            $pay->setRegion($this);
        }

        return $this;
    }

    public function removePay(Pays $pay): static
    {
        if ($this->pays->removeElement($pay)) {
            // set the owning side to null (unless already changed)
            if ($pay->getRegion() === $this) {
                $pay->setRegion(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nomReg;
    }
}
