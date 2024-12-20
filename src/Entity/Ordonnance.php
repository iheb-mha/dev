<?php

namespace App\Entity;

use App\Repository\OrdonnanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdonnanceRepository::class)]
class Ordonnance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEmission = null;

    #[ORM\ManyToOne(inversedBy: 'ordonnances')]
    private ?User $idClient = null;

    #[ORM\ManyToOne(inversedBy: 'idOrd')]
    private ?Medecin $medecin = null;

    #[ORM\ManyToOne(inversedBy: 'ordonnances')]
    private ?LigneMedicament $LigneMedicament = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmission(): ?\DateTimeInterface
    {
        return $this->dateEmission;
    }

    public function setDateEmission(\DateTimeInterface $dateEmission): static
    {
        $this->dateEmission = $dateEmission;

        return $this;
    }

    public function getIdClient(): ?User
    {
        return $this->idClient;
    }

    public function setIdClient(?User $idClient): static
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): static
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getLigneMedicament(): ?LigneMedicament
    {
        return $this->LigneMedicament;
    }

    public function setLigneMedicament(?LigneMedicament $LigneMedicament): static
    {
        $this->LigneMedicament = $LigneMedicament;

        return $this;
    }
}
