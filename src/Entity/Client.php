<?php

namespace App\Entity;



use Doctrine\DBAL\Types\Types;

  
  
  
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */

#[ORM\Entity(repositoryClass: ClientRepository::class)]

class Client extends Personne
{
    #[ORM\Column(name: "genre", type: "string", length: 30, nullable: false)]

    private ?string $genre='';

    #[ORM\Column(name: "age", type: "integer", nullable: false)]
    private ?int $age=0;
    
    #[ORM\OneToOne( inversedBy: "lesclient")]
    private ?Personne $idPersonne;
    public function getIdPersonne(): ?int
    {
        return $this->idPersonne;
    }

    public function setIdPersonne(?Personne $idPersonne): static
    {
        $this->idPersonne = $idPersonne;
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