<?php

namespace App\Entity;



use Doctrine\DBAL\Types\Types;

  
  
  
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */

#[ORM\Entity(repositoryClass: ClientRepository::class)]

class Client
{
    #[ORM\Id]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id_personne', nullable: true)]
    private ?Personne $personne = null;

    // #[ORM\Column(name: "id_personne", type: "integer")] // Map 'id' as integer type
    // protected ?int $idPersonne;

    #[ORM\Column(name: "genre", type: "string", length: 30, nullable: false)]
    protected ?string $genre='';

    #[ORM\Column(name: "age", type: "integer", nullable: false)]
    protected ?int $age=0;

    #[ORM\OneToOne(targetEntity: Place::class, mappedBy: "id_personne", cascade: ["persist", "remove"])]
    protected ?Place $place;
    
    // #[ORM\OneToOne(targetEntity: Personne::class)]
    // #[ORM\JoinColumn(name:"idPersonne", referencedColumnName:"idPersonne")]
    // protected ?int $idPersonne;
    // public function getIdPersonne(): ?int
    // {
    //     return $this->idPersonne;
    // }

    // public function setIdPersonne(?Personne $idPersonne): static
    // {
    //     $this->idPersonne = $idPersonne;
    //     return $this;
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