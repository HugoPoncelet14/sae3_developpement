<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    #[ORM\Column(length: 50)]
    private ?string $nomIng = null;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Allergene $allergene = null;

    #[ORM\OneToMany(mappedBy: 'ingredient', targetEntity: Quantite::class)]
    private Collection $quantites;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imgIng;

    public function __construct()
    {
        $this->quantites = new ArrayCollection();
    }

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

    public function getAllergene(): ?Allergene
    {
        return $this->allergene;
    }

    public function setAllergene(?Allergene $allergene): static
    {
        $this->allergene = $allergene;

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
            $quantite->setIngredient($this);
        }

        return $this;
    }

    public function removeQuantite(Quantite $quantite): static
    {
        if ($this->quantites->removeElement($quantite)) {
            // set the owning side to null (unless already changed)
            if ($quantite->getIngredient() === $this) {
                $quantite->setIngredient(null);
            }
        }

        return $this;
    }

    public function getImgIng()
    {
        return $this->imgIng;
    }

    public function setImgIng($imgIng): static
    {
        $this->imgIng = $imgIng;

        return $this;
    }
}
