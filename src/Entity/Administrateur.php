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
/**
     * @ORM\OneToOne(targetEntity="Personne")
     * @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     */
    private $personne;


    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }
    public function getPersonne()
    {
        return $this->personne;
    }

    public function setPersonne($personne): self
    {
        $this->personne = $personne;

        return $this;
    }

}