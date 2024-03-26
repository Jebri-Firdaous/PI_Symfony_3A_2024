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
   

    public function __construct(string $nom_personne=null, string $prenom_personne=null, int $numero_telephone=null, string $mail_personne=null, string  $mdp_personne=null, string  $image_personne=null, ?int $age=null, ?string $genre=null)
    {
        parent::__construct($nom_personne, $prenom_personne, $numero_telephone, $mail_personne, $mdp_personne, $image_personne);
        $this->age = $age;
        $this->genre = $genre;
    }
    

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
  
  
}
