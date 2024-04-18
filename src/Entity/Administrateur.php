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
    private ?string $role = '';

    #[ORM\Column(name: "idPersonne", type: "integer")] // Map 'id' as integer type
    protected ?int $idPersonne;

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }
    // public function getIdPersonne(): ?int
    // {
    //     return $this->idPersonne;
    // }
}