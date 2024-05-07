<?php

namespace App\Entity;

use repository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;
use App\Repository\CommandeRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCommande;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le nombre d'articles est requis")]
    #[Assert\Type(type: 'integer', message: "Le nombre d'articles doit être un entier")]
    #[Assert\PositiveOrZero(message: "Le nombre d'articles doit être positif ou zéro")]
    private ?int $nombreArticle;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: "Le prix total est requis")]
    #[Assert\Type(type: 'numeric', message: "Le prix total doit être numérique")]
    #[Assert\PositiveOrZero(message: "Le prix total doit être positif ou zéro")]
    private ?string $prixTotale;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le délai de commande est requis")]
    #[Assert\Type(type: '\DateTime', message: "Le délai de commande doit être une date")]
    private ?DateTime $delaisCommande;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "lesReservatoin")]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id')]
    #[Assert\NotBlank(
        message:'Cette valeur ne doit pas être vide'

    )]

    public User $user;

    // private User $id;


 

    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    public function getNombreArticle(): ?int
    {
        return $this->nombreArticle;
    }

    public function setNombreArticle(int $nombreArticle): static
    {
        $this->nombreArticle = $nombreArticle;

        return $this;
    }

    public function getPrixTotale(): ?string
    {
        return $this->prixTotale;
    }

    public function setPrixTotale(string $prixTotale): static
    {
        $this->prixTotale = $prixTotale;

        return $this;
    }

    public function getDelaisCommande(): ?\DateTimeInterface
    {
        return $this->delaisCommande;
    }

    public function setDelaisCommande(\DateTimeInterface $delaisCommande): static
    {
        $this->delaisCommande = $delaisCommande;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    
    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    


}