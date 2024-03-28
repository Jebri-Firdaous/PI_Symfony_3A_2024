<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminRepository;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
#[ORM\Entity(repositoryClass: AdminRepository::class)]

class Administrateur extends Personne
{
    #[ORM\Column(length: 30)]
    private ?string $role = null;

    #[ORM\OneToOne( inversedBy: "administrateur")]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id_personne')]
    private ?Personne $personne = null;

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): static
    {
        $this->role = $role;

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
