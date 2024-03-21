<?php

namespace App\Entity;

use repository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Commande;
use App\Entity\Article;
use App\Repository\CommandeArticleRepository;

#[ORM\Entity(repositoryClass: CommandeArticleRepository::class)]
class CommandeArticle
{
    #[ORM\OneToOne(inversedBy: 'lesCommandes')]
    private ?Commande $idCommande;

    #[ORM\ManyToMany(inversedBy: 'lesArticles')]
    private ?Article $idArticle;

    public function getIdCommande(): ?Commande
    {
        return $this->idCommande;
    }

    public function setIdCommande(?Commande $idCommande): static
    {
        $this->idCommande = $idCommande;

        return $this;
    }

    public function getIdArticle(): ?Article
    {
        return $this->idArticle;
    }
    
    public function setIdArticle(?Article $idArticle): static
    {
        $this->idArticle = $idArticle;

        return $this;
    }


}
