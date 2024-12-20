<?php

namespace App\Entity;

use App\Repository\LigneBonDeCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneBonDeCommandeRepository::class)]
class LigneBonDeCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(targetEntity: Medicament::class)] // Many-to-One relationship
    #[ORM\JoinColumn(nullable: false)] // Ensure medicament is required
    private ?Medicament $medicament = null; // Single Medicament

    #[ORM\ManyToOne(targetEntity: BonDeCommande::class, inversedBy: 'ligneCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BonDeCommande $bonDeCommande = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ligneBonDeCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null; // Changed from userId to user for clarity

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMedicament(): ?Medicament
    {
        return $this->medicament;
    }

    public function setMedicament(?Medicament $medicament): static
    {
        $this->medicament = $medicament;

        return $this;
    }

    public function getBonDeCommande(): ?BonDeCommande
    {
        return $this->bonDeCommande;
    }

    public function setBonDeCommande(?BonDeCommande $bonDeCommande): static
    {
        $this->bonDeCommande = $bonDeCommande;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}