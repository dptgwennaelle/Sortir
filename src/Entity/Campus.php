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

    #[ORM\OneToMany(targetEntity: Sortie::class, mappedBy: 'listesSorties', orphanRemoval: true)]
    private Collection $campus;

    public function __construct()
    {
        $this->campus = new ArrayCollection();
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
    public function getCampus(): Collection
    {
        return $this->campus;
    }

    public function addCampus(Sortie $campus): static
    {
        if (!$this->campus->contains($campus)) {
            $this->campus->add($campus);
            $campus->setListesSorties($this);
        }

        return $this;
    }

    public function removeCampus(Sortie $campus): static
    {
        if ($this->campus->removeElement($campus)) {
            // set the owning side to null (unless already changed)
            if ($campus->getListesSorties() === $this) {
                $campus->setListesSorties(null);
            }
        }

        return $this;
    }
}
