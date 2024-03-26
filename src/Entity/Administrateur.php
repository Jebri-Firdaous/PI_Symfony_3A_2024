<?php

namespace App\Entity;

use App\Entity\Personne;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminRepository;






/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 */

#[ORM\Entity(repositoryClass: AdminRepository::class)]


class Administrateur extends Personne
{
    #[ORM\Column(name: "role", type: "string", length: 30, nullable: false)]

    private ?string $role = null;


    public function __construct(string $nom_personne=null, string $prenom_personne=null, int $numero_telephone=null, string $mail_personne=null, string  $mdp_personne=null, string  $image_personne=null, ?string $role=null)
    {
        parent::__construct($nom_personne, $prenom_personne, $numero_telephone, $mail_personne, $mdp_personne, $image_personne);
        $this->role= $role;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

}
