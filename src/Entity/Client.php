<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

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
    private ?string $genre = null;

    #[ORM\Column]
    private ?int $age = null;

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
}
