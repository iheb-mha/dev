<?php
// src/Entity/LigneMedicament.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class LigneMedicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $numLigne;

    #[ORM\ManyToOne(targetEntity: Medicament::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $medicament;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;
        return $this;
    }

    public function getNumLigne(): ?int
    {
        return $this->numLigne;
    }

    public function setNumLigne(?int $numLigne): self
    {
        $this->numLigne = $numLigne;
        return $this;
    }

    public function getMedicament(): ?Medicament
    {
        return $this->medicament;
    }

    public function setMedicament(?Medicament $medicament): self
    {
        $this->medicament = $medicament;
        return $this;
    }
}