<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var string The user role
     */
    #[ORM\Column(length: 20)]
    private string $role = 'PHARMACIEN';

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 30)]
    private ?string $nom = null;

    #[ORM\Column(length: 30)]
    private ?string $prenom = null;

    #[ORM\Column(length: 20)]
    private ?string $numTel = null;

    /**
     * @var Collection<int, Ordonnance>
     */
    #[ORM\OneToMany(targetEntity: Ordonnance::class, mappedBy: 'idClient')]
    private Collection $ordonnances;

    /**
     * @var Collection<int, Recu>
     */
    #[ORM\OneToMany(targetEntity: Recu::class, mappedBy: 'idClient')]
    private Collection $recus;

    /**
     * @var Collection<int, LigneBonDeCommande>
     */
    #[ORM\OneToMany(targetEntity: LigneBonDeCommande::class, mappedBy: 'userId')]
    private Collection $ligneBonDeCommandes;



    public function __construct()
    {
        $this->ordonnances = new ArrayCollection();
        $this->recus = new ArrayCollection();
        $this->ligneBonDeCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): static
    {
        $this->numTel = $numTel;

        return $this;
    }

    /**
     * @return Collection<int, Ordonnance>
     */
    public function getOrdonnances(): Collection
    {
        return $this->ordonnances;
    }

    public function addOrdonnance(Ordonnance $ordonnance): static
    {
        if (!$this->ordonnances->contains($ordonnance)) {
            $this->ordonnances->add($ordonnance);
            $ordonnance->setIdClient($this);
        }

        return $this;
    }

    public function removeOrdonnance(Ordonnance $ordonnance): static
    {
        if ($this->ordonnances->removeElement($ordonnance)) {
            // set the owning side to null (unless already changed)
            if ($ordonnance->getIdClient() === $this) {
                $ordonnance->setIdClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recu>
     */
    public function getRecus(): Collection
    {
        return $this->recus;
    }

    public function addRecu(Recu $recu): static
    {
        if (!$this->recus->contains($recu)) {
            $this->recus->add($recu);
            $recu->setIdClient($this);
        }

        return $this;
    }

    public function removeRecu(Recu $recu): static
    {
        if ($this->recus->removeElement($recu)) {
            // set the owning side to null (unless already changed)
            if ($recu->getIdClient() === $this) {
                $recu->setIdClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LigneBonDeCommande>
     */
    public function getLigneBonDeCommandes(): Collection
    {
        return $this->ligneBonDeCommandes;
    }

    public function addLigneBonDeCommande(LigneBonDeCommande $ligneBonDeCommande): static
    {
        if (!$this->ligneBonDeCommandes->contains($ligneBonDeCommande)) {
            $this->ligneBonDeCommandes->add($ligneBonDeCommande);
            $ligneBonDeCommande->setUserId($this);
        }

        return $this;
    }

    public function removeLigneBonDeCommande(LigneBonDeCommande $ligneBonDeCommande): static
    {
        if ($this->ligneBonDeCommandes->removeElement($ligneBonDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneBonDeCommande->getUserId() === $this) {
                $ligneBonDeCommande->setUserId(null);
            }
        }

        return $this;
    }


}