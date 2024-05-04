<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD

#[ORM\Entity(repositoryClass: AdministrateurRepository::class)]
class Administrateur
=======
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: AdministrateurRepository::class)]
class Administrateur implements UserInterface
>>>>>>> 37caec1e37e945f6c482a8a42503aea11ab64dea
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    #[ORM\Id]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id_personne', nullable: true)]
<<<<<<< HEAD
    private ?Personne $personne = null;

    #[ORM\Column(length: 30)]
=======
    #[Assert\Valid] // Ajout de la validation pour le champ personne

    private ?Personne $personne = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "Le role ne peut pas être vide.")]
>>>>>>> 37caec1e37e945f6c482a8a42503aea11ab64dea
    private ?string $role = null;

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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }
<<<<<<< HEAD
=======
    public function getPassword() {
        // Check if Personne is set before accessing its properties
        if ($this->personne) {
            return $this->personne->getMdpPersonne(); 
        }
        return null; // Return null if Personne is not set
     }

    public function getSalt() {
        return null;
    }

    public function getUserIdentifier() {
        return $this->getPersonne()->getMailPersonne();
    }

    public function getUsername() {
        return $this->getPersonne()->getMailPersonne();
    }

    public function getRoles() {
        return [];
    }

    public function eraseCredentials(){

    }

>>>>>>> 37caec1e37e945f6c482a8a42503aea11ab64dea
}
