<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 1000)]
    private ?string $descRec = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imgRec;

    #[ORM\Column]
    private ?int $tpsDePrep = null;

    #[ORM\Column(nullable: true)]
    private ?int $tpsCuisson = null;

    #[ORM\Column]
    private ?float $nbrCallo = null;

    #[ORM\Column]
    private ?int $nbrPers = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?TypeRecette $typeRecette = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?Pays $pays = null;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: Quantite::class)]
    private Collection $quantites;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: Etape::class)]
    private Collection $etapes;

    #[ORM\ManyToMany(targetEntity: Ustensile::class, inversedBy: 'recettes')]
    private Collection $ustensiles;

    public function __construct()
    {
        $this->quantites = new ArrayCollection();
        $this->etapes = new ArrayCollection();
        $this->ustensiles = new ArrayCollection();
    }

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

    public function getTypeRecette(): ?TypeRecette
    {
        return $this->typeRecette;
    }

    public function setTypeRecette(?TypeRecette $typeRecette): static
    {
        $this->typeRecette = $typeRecette;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, Quantite>
     */
    public function getQuantites(): Collection
    {
        return $this->quantites;
    }

    public function addQuantite(Quantite $quantite): static
    {
        if (!$this->quantites->contains($quantite)) {
            $this->quantites->add($quantite);
            $quantite->setRecette($this);
        }

        return $this;
    }

    public function removeQuantite(Quantite $quantite): static
    {
        if ($this->quantites->removeElement($quantite)) {
            // set the owning side to null (unless already changed)
            if ($quantite->getRecette() === $this) {
                $quantite->setRecette(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Etape>
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etape $etape): static
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes->add($etape);
            $etape->setRecette($this);
        }

        return $this;
    }

    public function removeEtape(Etape $etape): static
    {
        if ($this->etapes->removeElement($etape)) {
            // set the owning side to null (unless already changed)
            if ($etape->getRecette() === $this) {
                $etape->setRecette(null);
            }
        }

        return $this;
    }

    public function getTpsCuisson(): ?int
    {
        return $this->tpsCuisson;
    }

    public function setTpsCuisson(?int $tpsCuisson): static
    {
        $this->tpsCuisson = $tpsCuisson;

        return $this;
    }

    /**
     * @return Collection<int, Ustensile>
     */
    public function getUstensiles(): Collection
    {
        return $this->ustensiles;
    }

    public function addUstensile(Ustensile $ustensile): static
    {
        if (!$this->ustensiles->contains($ustensile)) {
            $this->ustensiles->add($ustensile);
        }

        return $this;
    }

    public function removeUstensile(Ustensile $ustensile): static
    {
        $this->ustensiles->removeElement($ustensile);

        return $this;
    }
}
