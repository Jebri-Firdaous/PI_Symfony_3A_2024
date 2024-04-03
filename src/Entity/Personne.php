<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_personne = null;

    #[ORM\Column(length: 30)]
    private ?string $nom_personne = null;

    #[ORM\Column(length: 30)]
    private ?string $prenom_personne = null;

    #[ORM\Column]
    private ?int $numero_telephone = null;

    #[ORM\Column(length: 50)]
    private ?string $mail_personne = null;

    #[ORM\Column(length: 50)]
    private ?string $mdp_personne = null;

    #[ORM\Column(length: 255)]
    private ?string $image_personne = null;

    public function getId(): ?int
    {
        return $this->id_personne;
    }

    public function getNomPersonne(): ?string
    {
        return $this->nom_personne;
    }

    public function setNomPersonne(string $nom_personne): static
    {
        $this->nom_personne = $nom_personne;

        return $this;
    }

    public function getPrenomPersonne(): ?string
    {
        return $this->prenom_personne;
    }

    public function setPrenomPersonne(string $prenom_personne): static
    {
        $this->prenom_personne = $prenom_personne;

        return $this;
    }

    public function getNumeroTelephone(): ?int
    {
        return $this->numero_telephone;
    }

    public function setNumeroTelephone(int $numero_telephone): static
    {
        $this->numero_telephone = $numero_telephone;

        return $this;
    }

    public function getMailPersonne(): ?string
    {
        return $this->mail_personne;
    }

    public function setMailPersonne(string $mail_personne): static
    {
        $this->mail_personne = $mail_personne;

        return $this;
    }

    public function getMdpPersonne(): ?string
    {
        return $this->mdp_personne;
    }

    public function setMdpPersonne(string $mdp_personne): static
    {
        $this->mdp_personne = $mdp_personne;

        return $this;
    }

    public function getImagePersonne(): ?string
    {
        return $this->image_personne;
    }

    public function setImagePersonne(string $image_personne): static
    {
        $this->image_personne = $image_personne;

        return $this;
    }
    public function __toString()
    {
        return $this->getNomPersonne()  ." ". $this->getPrenomPersonne()  ;
    }
}

