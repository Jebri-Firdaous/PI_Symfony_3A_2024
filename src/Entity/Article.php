<?php

namespace App\Entity;

use repository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idArticle;

    #[ORM\Column(length: 30)]
    private ?string $nomArticle;

    #[ORM\Column]
    private ?float $prixArticle;

    #[ORM\Column]
    private ?int $quantiteArticle ;

    #[ORM\Column(length: 255)]
    private ?string $typeArticle = null;

    #[ORM\Column(length: 255)]
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
