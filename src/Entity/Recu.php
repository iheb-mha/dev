<?php

namespace App\Entity;

use App\Repository\RecuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecuRepository::class)]
class Recu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $totale = null;

    #[ORM\ManyToOne(inversedBy: 'recus')]
    private ?user $idClient = null;

    /**
     * @var Collection<int, LigneMedicament>
     */
    #[ORM\ManyToMany(targetEntity: LigneMedicament::class, inversedBy: 'recus')]
    private Collection $LigneMed;

    public function __construct()
    {
        $this->LigneMed = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotale(): ?float
    {
        return $this->totale;
    }

    public function setTotale(float $totale): static
    {
        $this->totale = $totale;

        return $this;
    }

    public function getIdClient(): ?user
    {
        return $this->idClient;
    }

    public function setIdClient(?user $idClient): static
    {
        $this->idClient = $idClient;

        return $this;
    }

    /**
     * @return Collection<int, LigneMedicament>
     */
    public function getLigneMed(): Collection
    {
        return $this->LigneMed;
    }

    public function addLigneMed(LigneMedicament $ligneMed): static
    {
        if (!$this->LigneMed->contains($ligneMed)) {
            $this->LigneMed->add($ligneMed);
        }

        return $this;
    }

    public function removeLigneMed(LigneMedicament $ligneMed): static
    {
        $this->LigneMed->removeElement($ligneMed);

        return $this;
    }
}
