<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureDebut = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateLimiteInscription = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $nbInscriptionsMax = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $infosSortie = null;

    #[ORM\ManyToOne(inversedBy: 'campus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $listesSorties = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $sorties = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieu $sortie = null;

    #[ORM\ManyToOne(inversedBy: 'listeSortiesOrganisees')]
    private ?Participant $listeSortiesOrganisees = null;

    #[ORM\ManyToMany(targetEntity: Participant::class, mappedBy: 'listeSortiesDuParticipant')]
    private Collection $listeSortiesDuParticipant;

    #[ORM\ManyToMany(targetEntity: Participant::class, inversedBy: 'personnesInscrites')]
    private Collection $personnesInscrites;

    public function __construct()
    {
        $this->listeSortiesDuParticipant = new ArrayCollection();
        $this->personnesInscrites = new ArrayCollection();
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

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): static
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): static
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nbInscriptionsMax;
    }

    public function setNbInscriptionsMax(int $nbInscriptionsMax): static
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(?string $infosSortie): static
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getListesSorties(): ?Campus
    {
        return $this->listesSorties;
    }

    public function setListesSorties(?Campus $listesSorties): static
    {
        $this->listesSorties = $listesSorties;

        return $this;
    }

    public function getSorties(): ?Etat
    {
        return $this->sorties;
    }

    public function setSorties(?Etat $sorties): static
    {
        $this->sorties = $sorties;

        return $this;
    }

    public function getSortie(): ?Lieu
    {
        return $this->sortie;
    }

    public function setSortie(?Lieu $sortie): static
    {
        $this->sortie = $sortie;

        return $this;
    }

    public function getListeSortiesOrganisees(): ?Participant
    {
        return $this->listeSortiesOrganisees;
    }

    public function setListeSortiesOrganisees(?Participant $listeSortiesOrganisees): static
    {
        $this->listeSortiesOrganisees = $listeSortiesOrganisees;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getListeSortiesDuParticipant(): Collection
    {
        return $this->listeSortiesDuParticipant;
    }

    public function addListeSortiesDuParticipant(Participant $listeSortiesDuParticipant): static
    {
        if (!$this->listeSortiesDuParticipant->contains($listeSortiesDuParticipant)) {
            $this->listeSortiesDuParticipant->add($listeSortiesDuParticipant);
            $listeSortiesDuParticipant->addListeSortiesDuParticipant($this);
        }

        return $this;
    }

    public function removeListeSortiesDuParticipant(Participant $listeSortiesDuParticipant): static
    {
        if ($this->listeSortiesDuParticipant->removeElement($listeSortiesDuParticipant)) {
            $listeSortiesDuParticipant->removeListeSortiesDuParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getPersonnesInscrites(): Collection
    {
        return $this->personnesInscrites;
    }

    public function addPersonnesInscrite(Participant $personnesInscrite): static
    {
        if (!$this->personnesInscrites->contains($personnesInscrite)) {
            $this->personnesInscrites->add($personnesInscrite);
        }

        return $this;
    }

    public function removePersonnesInscrite(Participant $personnesInscrite): static
    {
        $this->personnesInscrites->removeElement($personnesInscrite);

        return $this;
    }
}
