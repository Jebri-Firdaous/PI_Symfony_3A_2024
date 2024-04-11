<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;




#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    #[ORM\Id]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id_personne', nullable: true)]
    private ?Personne $personne = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "Le genre ne peut pas être vide.")]
    private ?string $genre = null;

    #[ORM\Column]
    #[Assert\Range(min: 15, max: 100, minMessage: "L'âge minimum est 15 ans.", maxMessage: "L'âge maximum est 100 ans.")]
    #[Assert\Regex(pattern: "/^\d+$/", message: "L'âge doit contenir uniquement des chiffres.")]
    private ?int $age = null;

    #[ORM\OneToMany(mappedBy: "id_personne", targetEntity: RendezVous::class, cascade: ['persist', 'remove'])]
    private $lesRendezVous;

    public function __construct()
    {
        $this->lesRendezVous = new ArrayCollection();
    }

    /**
     * @return Collection|RendezVous[]
     */
    public function getLesRendezVous(): Collection
    {
        return $this->lesRendezVous;
    }

    public function addLesRendezVous(RendezVous $rendezVous): self
    {
        if (!$this->lesRendezVous->contains($rendezVous)) {
            $this->lesRendezVous[] = $rendezVous;
            $rendezVous->setIdPersonne($this);
        }

        return $this;
    }

    public function removeLesRendezVous(RendezVous $rendezVous): self
    {
        if ($this->lesRendezVous->removeElement($rendezVous)) {
            // set the owning side to null (unless already changed)
            if ($rendezVous->getClient() === $this) {
                $rendezVous->setIdPersonne(null);
            }
        }

        return $this;
    }


    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(Personne $personne): static
    {
        $this->personne = $personne;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }
    public function __toString()
    {
        return $this->getPersonne();
    }
}

