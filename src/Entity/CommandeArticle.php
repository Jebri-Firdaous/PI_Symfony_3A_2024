<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Commande;
use App\Entity\Article;

/**
 * CommandeArticle
 *
 * @ORM\Table(name="commande_article", indexes={@ORM\Index(name="id_commande", columns={"id_commande"}), @ORM\Index(name="id_article", columns={"id_article"})})
 * @ORM\Entity
 */
class CommandeArticle
{
    /**
     * @var \Commande
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_commande", referencedColumnName="id_commande")
     * })
     */
    private $idCommande;

    /**
     * @var \Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_article", referencedColumnName="id_article")
     * })
     */
    private $idArticle;

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
