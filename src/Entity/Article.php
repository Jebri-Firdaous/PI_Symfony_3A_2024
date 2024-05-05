<?php

// Article.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idArticle;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "Le nom de l'article est requis")]
    #[Assert\Length(max: 30, maxMessage: "Le nom de l'article ne peut pas dépasser {{ limit }} caractères")]
    private ?string $nomArticle;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le prix de l'article est requis")]
    #[Assert\Type(type: "float", message: "Le prix de l'article doit être un nombre")]
    #[Assert\Positive(message: "Le prix de l'article doit être un nombre positif")]
    private ?float $prixArticle;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La quantité de l'article est requise")]
    #[Assert\Type(type: "integer", message: "La quantité de l'article doit être un nombre entier")]
    #[Assert\PositiveOrZero(message: "La quantité de l'article doit être un nombre positif ou zéro")]
    private ?int $quantiteArticle;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La type de l'article est requise")]
    #[Assert\Choice(choices: ["Electronique", "Vetements", "Livres", "Appareils_menagers", "Equipements_sportifs", "Produits_de_beaute", "Meubles", "Jouets", "Alimentation_et_boissons", "Bijoux"], message: "Veuillez choisir un type valide")]
    private ?string $typeArticle = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La description de l'article est requise")]
    #[Assert\Length(max: 255, maxMessage: "La description de l'article ne peut pas dépasser {{ limit }} caractères")]
    private $descriptionArticle = null;

    #[ORM\Column(length: 255)]
    private $photoArticle = null;

  

    public function getIdArticle(): ?int
    {
        return $this->idArticle;
    }

    public function getNomArticle(): ?string
    {
        return $this->nomArticle;
    }

    public function setNomArticle(string $nomArticle): static
    {
        $this->nomArticle = $nomArticle;

        return $this;
    }

    public function getPrixArticle(): ?float
    {
        return $this->prixArticle;
    }

    public function setPrixArticle(float $prixArticle): static
    {
        $this->prixArticle = $prixArticle;

        return $this;
    }

    public function getQuantiteArticle(): ?int
    {
        return $this->quantiteArticle;
    }

    public function setQuantiteArticle(int $quantiteArticle): static
    {
        $this->quantiteArticle = $quantiteArticle;

        return $this;
    }

    public function getTypeArticle(): ?string
    {
        return $this->typeArticle;
    }

    public function setTypeArticle(?string $typeArticle): static
    {
        $this->typeArticle = $typeArticle;

        return $this;
    }

    public function getDescriptionArticle(): ?string
    {
        return $this->descriptionArticle;
    }

    public function setDescriptionArticle(?string $descriptionArticle): static
    {
        $this->descriptionArticle = $descriptionArticle;

        return $this;
    }

    public function getPhotoArticle(): ?string
    {
        return $this->photoArticle;
    }

    public function setPhotoArticle(?string $photoArticle): static
    {
        $this->photoArticle = $photoArticle;

        return $this;
    }
}
