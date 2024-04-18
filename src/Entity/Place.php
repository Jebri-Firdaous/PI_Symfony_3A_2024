<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;
use App\Entity\Parking;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\PlaceRepository;
use App\Repository\ParkingRepository;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $refPlace;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Positive(message:'doit etre positive')]
    #[Assert\Type("integer", message:'doit contenir que des chiffre')]
    private ?int $numPlace;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank()]
    private ?string $typePlace;

    #[ORM\Column(length: 30)]
    private ?string $etat;

    #[ORM\ManyToOne(inversedBy: 'places', targetEntity: Parking::class)]
    #[ORM\JoinColumn(name: 'id_parking', referencedColumnName: 'id_parking')]
    private ?Parking $idParking;

    // #[ORM\OneToOne(targetEntity: Client::class)]
    // #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'idPersonne')]
    #[ORM\OneToOne(targetEntity: Client::class, inversedBy: "place")]
    #[ORM\JoinColumn(name: "id_personne", referencedColumnName: "id_personne")]
    private ?Client $id_personne;

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

    public function getIdPersonne(): ?Client
    {
        return $this->id_personne;
    }

    public function setIdPersonne(?Client $idUser): static
    {
        $this->id_personne = $idUser;

        return $this;
    }


}
