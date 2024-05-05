<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;




#[ORM\Entity(repositoryClass: UserRepository::class)]
#[Vich\Uploadable]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    /*--------------------------------------------------------------------------------------------------------------------------- */
    /*mail de la personne */
    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "L'adresse e-mail est requise")]
    #[Assert\Regex(
        pattern: '/^(.+)@(gmail|esprit|yahoo|hotmail)\.(tn|com)$/',
        message: "Veuillez saisir une adresse e-mail valide (@gmail, @esprit, @yahoo, @hotmail) avec une extension .tn ou .com."
    )]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */

    /*--------------------------------------------------------------------------------------------------------------------------- */
    /*mdp_personne de la personne */
    #[ORM\Column(length: 50)]
    #[Assert\Length(
        min: 10,
        minMessage: "Le mot de passe doit contenir au moins 10 caractères."
    )]
    #[Assert\Regex(
        pattern: '/^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*[A-Z])(?=.*\d).*$/',
        message: "(doit contenir au moins une lettre majuscule, un chiffre et un caractère spécial)."
    )]
    private ?string $password = null;

    /*--------------------------------------------------------------------------------------------------------------------------- */
    /*nom de la personne */
    #[ORM\Column(length: 30, nullable: true)]
    #[Assert\NotBlank(message: "Le nom est requis")]
    #[Assert\Length(max: 30, maxMessage: "Le nom ne peut pas dépasser 30 caractères")]
    #[Assert\Regex(
    pattern: '/^[a-zA-Z]*$/',
    message: "Le nom ne peut contenir que des lettres."
    )]    private ?string $nom_personne = null;

    /*--------------------------------------------------------------------------------------------------------------------------- */
    /*prenom de la personne */
    #[ORM\Column(length: 30, nullable: true)]
    #[Assert\NotBlank(message: "Le prenom est requis")]
    #[Assert\Length(max: 30, maxMessage: "Le prenom ne peut pas dépasser 30 caractères")]
    #[Assert\Regex(
    pattern: '/^[a-zA-Z]*$/',
    message: "Le prenom ne peut contenir que des lettres."
    )]    
    private ?string $prenom_personne = null;
    
    /*--------------------------------------------------------------------------------------------------------------------------- */
    /* image de la personne */
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "L'image ne peut pas être vide.")]
    #[Assert\File(mimeTypes:["image/png", "image/jpeg", "image/jpg"], mimeTypesMessage:"Veuillez télécharger un fichier d'image valide (PNG, JPEG, JPG).")]
    private ?string $image_personne = null;
    /**
     * @Vich\UploadableField(mapping="user", fileNameProperty="image_personne")
     * @var file
     */
    private ?File $imageFile = null;

    // Other methods...



    /*--------------------------------------------------------------------------------------------------------------------------- */
    /* role de l'administrateur */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $roleAdmin = null;

    /*--------------------------------------------------------------------------------------------------------------------------- */
    /*genre de client */
    #[ORM\Column(nullable: true)]
    #[Assert\Positive(message: "L'âge doit être un nombre positif.")]
    private ?int $age = null;

    /*--------------------------------------------------------------------------------------------------------------------------- */
    /*genre de client */
    #[ORM\Column(length: 30, nullable: true)]
    private ?string $genre = null;

    /*--------------------------------------------------------------------------------------------------------------------------- */
    /*telphone de la personne */
    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: "Le numero de telephone ne peut pas être vide.")]
    #[Assert\Regex(    pattern: '/^\d{8}$/', message: "L'âge doit contenir uniquement des chiffres (exactement 8).")]
    private ?int $numero_telephone = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isVerified = false;

    #[ORM\Column(nullable: true)]
    private ?bool $isBanned = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getemail(): ?string
    {
        return $this->email;
    }

    public function setemail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
    

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function setPrenomPersonne(?string $prenom_personne): static
    {
        $this->prenom_personne = $prenom_personne;

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

    /**
     *  @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    /*
     * @param File|null $imageFile
     */

    public function setImageFile(?File $imageFile=null): void
    {
        $this->imageFile = $imageFile;

        // It's necessary to trigger the update of the imagePersonne property,
        // if you're using Doctrine events, this will automatically update the database.
        if ($imageFile) {
            // You can include custom logic here if needed
        }
    }

    public function getRoleAdmin(): ?string
    {
        return $this->roleAdmin;
    }

    public function setRoleAdmin(?string $roleAdmin): static
    {
        $this->roleAdmin = $roleAdmin;

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

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getNumeroTelephone(): ?int
    {
        return $this->numero_telephone;
    }

    public function setNumeroTelephone(?int $numero_telephone): static
    {
        $this->numero_telephone = $numero_telephone;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(?bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(?bool $isBanned): static
    {
        $this->isBanned = $isBanned;

        return $this;
    }
    

}
