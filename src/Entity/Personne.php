<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_personne = null;

    /*--------------------------------------------------------------------------------------------------------------------------- */
    /*nom de la personne */
    #[ORM\Column(length: 30, nullable: true)]
    #[Assert\NotBlank(message: "Le nom est requis")]
    #[Assert\Length(max: 30, maxMessage: "Le nom ne peut pas dépasser 30 caractères")]
    #[Assert\Regex(
    pattern: '/^[a-zA-Z]*$/',
    message: "Le nom ne peut contenir que des lettres."
    )]
    private ?string $nom_personne = null;

     /*--------------------------------------------------------------------------------------------------------------------------- */
    /*prenom de la personne */
    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "Le prenom est requis")]
    #[Assert\Length(max: 30, maxMessage: "Le prenom ne peut pas dépasser 30 caractères")]
    #[Assert\Regex(
    pattern: '/^[a-zA-Z]*$/',
    message: "Le prenom ne peut contenir que des lettres."
    )]    
    private ?string $prenom_personne = null;

    /*--------------------------------------------------------------------------------------------------------------------------- */
    /*telphone de la personne */
    #[ORM\Column]
    #[Assert\NotBlank(message: "Le numéro de téléphone est requis")]
    #[Assert\Regex(
        pattern: '/^\d+$/',
        message: "Le numéro de téléphone ne doit contenir que des chiffres."
    )]
    #[Assert\Length(
        min: 8,
        max: 8,
        minMessage: "Le numéro de téléphone doit contenir au moins 8 chiffres.",
        maxMessage: "Le numéro de téléphone ne peut pas contenir plus de 8 chiffres."
    )]
    private ?int $numero_telephone = null;

    /*--------------------------------------------------------------------------------------------------------------------------- */
    /*mail de la personne */
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "L'adresse e-mail est requise")]
    #[Assert\Regex(
        pattern: '/^(.+)@(gmail|esprit|yahoo|hotmail)\.(tn|com)$/',
        message: "Veuillez saisir une adresse e-mail valide (@gmail, @esprit, @yahoo, @hotmail) avec une extension .tn ou .com."
    )]
    private ?string $mail_personne = null;

    /*--------------------------------------------------------------------------------------------------------------------------- */
    /*mdp_personne de la personne */
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le mot de passe est requis")]
    #[Assert\Length(
        min: 10,
        minMessage: "Le mot de passe doit contenir au moins 10 caractères."
    )]
    #[Assert\Regex(
        pattern: '/^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*[A-Z])(?=.*\d).*$/',
        message: "Le mot de passe doit contenir au moins une lettre majuscule, un chiffre et un caractère spécial."
    )]
    private ?string $mdp_personne = null;
    
    /*--------------------------------------------------------------------------------------------------------------------------- */
    /* image de la personne */
    #[ORM\Column(length: 255)]
    
    private ?string $image_personne = null;

    /*--------------------------------------------------------------------------------------------------------------------------- */
    /* ****************************** getter et setter ****************************************************************************/
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

