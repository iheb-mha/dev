<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicamentRepository::class)]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?int $qteStock = null;

    #[ORM\Column]
    private ?bool $surOrdonnance = null;

    #[ORM\Column(length: 255)]
    private ?string $typeMed = null;

    /**
     * @var Collection<int, LigneMedicament>
     */
    #[ORM\ManyToMany(targetEntity: LigneMedicament::class, mappedBy: 'idMedicament')]
    private Collection $ligneMedicaments;

    public function __construct()
    {
        $this->ligneMedicaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
    

    public function getQteStock(): ?int
    {
        return $this->qteStock;
    }

    public function setQteStock(int $qteStock): static
    {
        $this->qteStock = $qteStock;

        return $this;
    }

    public function isSurOrdonnance(): ?bool
    {
        return $this->surOrdonnance;
    }

    public function setSurOrdonnance(bool $surOrdonnance): static
    {
        $this->surOrdonnance = $surOrdonnance;

        return $this;
    }

    public function getTypeMed(): ?string
    {
        return $this->typeMed;
    }

    public function setTypeMed(string $typeMed): static
    {
        $this->typeMed = $typeMed;

        return $this;
    }

    /**
     * @return Collection<int, LigneMedicament>
     */
    public function getLigneMedicaments(): Collection
    {
        return $this->ligneMedicaments;
    }

    public function addLigneMedicament(LigneMedicament $ligneMedicament): static
    {
        if (!$this->ligneMedicaments->contains($ligneMedicament)) {
            $this->ligneMedicaments->add($ligneMedicament);
            $ligneMedicament->addIdMedicament($this);
        }

        return $this;
    }

    public function removeLigneMedicament(LigneMedicament $ligneMedicament): static
    {
        if ($this->ligneMedicaments->removeElement($ligneMedicament)) {
            $ligneMedicament->removeIdMedicament($this);
        }

        return $this;
    }
}
