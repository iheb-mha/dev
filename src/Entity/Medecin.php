<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nom = null;

    #[ORM\Column(length: 20)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $numTel = null;

    /**
     * @var Collection<int, Ordonnance>
     */
    #[ORM\OneToMany(targetEntity: Ordonnance::class, mappedBy: 'medecin')]
    private Collection $idOrd;

    public function __construct()
    {
        $this->idOrd = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->numTel;
    }

    public function setNumTel(int $numTel): static
    {
        $this->numTel = $numTel;

        return $this;
    }

    /**
     * @return Collection<int, Ordonnance>
     */
    public function getIdOrd(): Collection
    {
        return $this->idOrd;
    }

    public function addIdOrd(Ordonnance $idOrd): static
    {
        if (!$this->idOrd->contains($idOrd)) {
            $this->idOrd->add($idOrd);
            $idOrd->setMedecin($this);
        }

        return $this;
    }

    public function removeIdOrd(Ordonnance $idOrd): static
    {
        if ($this->idOrd->removeElement($idOrd)) {
            // set the owning side to null (unless already changed)
            if ($idOrd->getMedecin() === $this) {
                $idOrd->setMedecin(null);
            }
        }

        return $this;
    }
}
