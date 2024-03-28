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
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Commande::class)]
    #[ORM\JoinColumn(name: 'id_commande', referencedColumnName: 'id_commande')]
    private ?Commande $idCommande;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Article::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: 'id_article', referencedColumnName: 'id_article')]
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
