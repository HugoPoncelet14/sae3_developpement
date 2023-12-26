<?php

namespace App\Entity;

use App\Repository\UstensilesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UstensilesRepository::class)]
class Ustensiles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $name = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imgRec = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
}
