<?php

namespace App\Entity;
use repository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Station; 
use App\Entity\Client;
use DateTime;
use App\Repository\billetRepository ;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\billetRepository")
 */
#[ORM\Entity(repositoryClass: billetRepository::class)]
class Billet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $refVoyage;

    #[ORM\Column(length: 30)]
    #[Assert\Length(min:3, minMessage:"Destination doit contenir au minimum 3 caractères !")]
    #[Assert\NotBlank(message:"La destination est obligatoire")] 

    private ?string $destinationVoyage;

    #[ORM\Column]
    #[Assert\GreaterThan('today',message:"date non valide")]
    #[Assert\NotBlank(message:"La date est obligatoire")] 
    private ?\DateTime $dateDepart;

    #[ORM\Column(length: 50)]
    private ?string $prix;

    #[ORM\Column(length: 40)]
    private ?string $duree;

    #[ORM\ManyToOne(targetEntity: Station::class)]
    #[ORM\JoinColumn(name: 'station', referencedColumnName: 'id_station')]
    #[Assert\NotBlank(message:"La station est obligatoire")] 
    private ?Station $station;

    #[ORM\ManyToOne(targetEntity: client::class)]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id_personne')]
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


    public function setStation(?Station $station): static
    {
        $this->station = $station;

        return $this;
    }


    public function setIdPersonne(?Client $idPersonne): static
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function getIdPersonne(): ?Client
    {
        return $this->idPersonne;
    }


}
