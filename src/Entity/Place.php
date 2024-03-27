<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;
use App\Entity\Parking;

use App\Repository\PlaceRepository;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $refPlace;

    #[ORM\Column]
    private ?int $numPlace;

    #[ORM\Column(length: 30)]
    private ?string $typePlace;

    #[ORM\Column(length: 30)]
    private ?string $etat;

    #[ORM\ManyToOne(inversedBy: 'places', targetEntity: Parking::class)]
    private ?Parking $idParking;

    #[ORM\OneToOne(mappedBy: 'idPersonne', targetEntity: Client::class)]
    private ?Client $idUser;

    public function getRefPlace(): ?int
    {
        return $this->refPlace;
    }

    public function getNumPlace(): ?int
    {
        return $this->numPlace;
    }

    public function setNumPlace(int $numPlace): static
    {
        $this->numPlace = $numPlace;

        return $this;
    }

    public function getTypePlace(): ?string
    {
        return $this->typePlace;
    }

    public function setTypePlace(string $typePlace): static
    {
        $this->typePlace = $typePlace;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdParking(): ?Parking
    {
        return $this->idParking;
    }

    public function setIdParking(?Parking $idParking): static
    {
        $this->idParking = $idParking;

        return $this;
    }

    public function getIdUser(): ?Client
    {
        return $this->idUser;
    }

    public function setIdUser(?Client $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }


}
