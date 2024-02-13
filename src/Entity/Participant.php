<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Faker\Factory;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
#[UniqueEntity(fields: ['identifiant'], message: 'There is already an account with this identifiant')]
class Participant implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $identifiant = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: Sortie::class, mappedBy: 'listeSortiesOrganisees')]
    private Collection $listeSortiesOrganisees;

    #[ORM\ManyToMany(targetEntity: Sortie::class, inversedBy: 'listeSortiesDuParticipant')]
    private Collection $listeSortiesDuParticipant;

    #[ORM\ManyToMany(targetEntity: Sortie::class, mappedBy: 'personnesInscrites')]
    private Collection $personnesInscrites;

    public function __construct()
    {
        $this->listeSortiesOrganisees = new ArrayCollection();
        $this->listeSortiesDuParticipant = new ArrayCollection();
        $this->personnesInscrites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): static
    {
        $this->identifiant = $identifiant;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->identifiant;

    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getListeSortiesOrganisees(): Collection
    {
        return $this->listeSortiesOrganisees;
    }

    public function addListeSortiesOrganisee(Sortie $listeSortiesOrganisee): static
    {
        if (!$this->listeSortiesOrganisees->contains($listeSortiesOrganisee)) {
            $this->listeSortiesOrganisees->add($listeSortiesOrganisee);
            $listeSortiesOrganisee->setListeSortiesOrganisees($this);
        }

        return $this;
    }

    public function removeListeSortiesOrganisee(Sortie $listeSortiesOrganisee): static
    {
        if ($this->listeSortiesOrganisees->removeElement($listeSortiesOrganisee)) {
            // set the owning side to null (unless already changed)
            if ($listeSortiesOrganisee->getListeSortiesOrganisees() === $this) {
                $listeSortiesOrganisee->setListeSortiesOrganisees(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getListeSortiesDuParticipant(): Collection
    {
        return $this->listeSortiesDuParticipant;
    }

    public function addListeSortiesDuParticipant(Sortie $listeSortiesDuParticipant): static
    {
        if (!$this->listeSortiesDuParticipant->contains($listeSortiesDuParticipant)) {
            $this->listeSortiesDuParticipant->add($listeSortiesDuParticipant);
        }

        return $this;
    }

    public function removeListeSortiesDuParticipant(Sortie $listeSortiesDuParticipant): static
    {
        $this->listeSortiesDuParticipant->removeElement($listeSortiesDuParticipant);

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getPersonnesInscrites(): Collection
    {
        return $this->personnesInscrites;
    }

    public function addPersonnesInscrite(Sortie $personnesInscrite): static
    {
        if (!$this->personnesInscrites->contains($personnesInscrite)) {
            $this->personnesInscrites->add($personnesInscrite);
            $personnesInscrite->addPersonnesInscrite($this);
        }

        return $this;
    }

    public function removePersonnesInscrite(Sortie $personnesInscrite): static
    {
        if ($this->personnesInscrites->removeElement($personnesInscrite)) {
            $personnesInscrite->removePersonnesInscrite($this);
        }

        return $this;
    }
}
