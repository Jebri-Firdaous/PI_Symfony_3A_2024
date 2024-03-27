<?php

namespace App\Entity;

use repository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;
use App\Repository\CommandeRepository;
use DateTime;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCommande;

    #[ORM\Column]
    private ?int $nombreArticle;

    #[ORM\Column(length: 10)]
    private ?string $prixTotale;

    #[ORM\Column]
    private ?DateTime $delaisCommande;

    #[ORM\ManyToOne(targetEntity: client::class)]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id_personne')]
    private ?Client $idPersonne;

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