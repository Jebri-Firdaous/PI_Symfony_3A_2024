<?php

namespace App\Entity;
use repository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Station; 
use App\Entity\Client;
use DateTime;
use App\Repository\billetRepository ;
/**
 * @ORM\Entity(repositoryClass="App\Repository\billetRepository")
 */
#[ORM\Entity(repositoryClass: billetRepository::class)]
class Billet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $refVoyage = null;

    #[ORM\Column(length:30)]
    private ?string $destinationVoyage = null;

    #[ORM\Column]
    private ?DateTime $dateDepart = null ;

    #[ORM\Column(length:50)]
    private $prix;

    #[ORM\Column(length:40)]
    private $duree;

#[ORM\ManyToOne(inversedBy:'LesBilletsdeChaqueStation')]
    private ?Station $station;

    #[ORM\ManyToOne(inversedBy: 'lesClients')]
    private ?Client $idPersonne;

    public function getRefVoyage(): ?int
    {
        return $this->refVoyage;
    }

    public function getDestinationVoyage(): ?string
    {
        return $this->destinationVoyage;
    }

    public function setDestinationVoyage(string $destinationVoyage): static
    {
        $this->destinationVoyage = $destinationVoyage;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): static
    {
        $this->station = $station;

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
