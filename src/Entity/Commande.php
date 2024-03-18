<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="id_personne", columns={"id_personne"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_article", type="integer", nullable=false)
     */
    private $nombreArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_totale", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $prixTotale;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="delais_commande", type="date", nullable=false)
     */
    private $delaisCommande;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     * })
     */
    private $idPersonne;

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

    public function getIdPersonne(): ?Client
    {
        return $this->idPersonne;
    }

    public function setIdPersonne(?Client $idPersonne): static
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }


}
