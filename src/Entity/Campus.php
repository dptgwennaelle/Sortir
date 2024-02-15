<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Sortie::class, orphanRemoval: true)]
    private Collection $listeSorties;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Participant::class, orphanRemoval: true)]
    private Collection $listeEleves;

    public function __construct()
    {
        $this->listeSorties = new ArrayCollection();
        $this->listeEleves = new ArrayCollection();
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

    /**
     * @return Collection<int, Sortie>
     */
    public function getListeSorties(): Collection
    {
        return $this->listeSorties;
    }

    public function addListeSorty(Sortie $listeSorty): static
    {
        if (!$this->listeSorties->contains($listeSorty)) {
            $this->listeSorties->add($listeSorty);
            $listeSorty->setCampus($this);
        }

        return $this;
    }

    public function removeListeSorty(Sortie $listeSorty): static
    {
        if ($this->listeSorties->removeElement($listeSorty)) {
            // set the owning side to null (unless already changed)
            if ($listeSorty->getCampus() === $this) {
                $listeSorty->setCampus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getListeEleves(): Collection
    {
        return $this->listeEleves;
    }

    public function addListeElefe(Participant $listeElefe): static
    {
        if (!$this->listeEleves->contains($listeElefe)) {
            $this->listeEleves->add($listeElefe);
            $listeElefe->setCampus($this);
        }

        return $this;
    }

    public function removeListeElefe(Participant $listeElefe): static
    {
        if ($this->listeEleves->removeElement($listeElefe)) {
            // set the owning side to null (unless already changed)
            if ($listeElefe->getCampus() === $this) {
                $listeElefe->setCampus(null);
            }
        }

        return $this;
    }
}
