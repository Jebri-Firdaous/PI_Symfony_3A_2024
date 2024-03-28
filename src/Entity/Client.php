<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
#[ORM\Entity(repositoryClass: ClientRepository::class)]

class Client extends Personne
{
    #[ORM\Column( length: 30)]
    private ?string $genre = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\OneToOne( inversedBy: "lesclient")]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id_personne')]
    private ?Personne $personne = null;

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): static
    {
        $this->personne = $personne;

        return $this;
    }
}
