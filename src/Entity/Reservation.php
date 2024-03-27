<?php

namespace App\Entity;
use App\Entity\Hotel;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;
use App\Repository\ReservationRepository;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
#[ORM\Entity(repositoryClass: ReservationRepository::class)]

class Reservation
{
   

     #[ORM\Id]
     #[ORM\GeneratedValue]
     #[ORM\Column]
     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $refReservation = null;

   
    #[ORM\Column]
    private ?float  $dureeReservation = null;

   

     #[ORM\Column]
   
    private ?float  $prixReservation = null ;

  
    

    #[ORM\Column]
     private ?\DateTime $dateReservation = null;

 
    #[ORM\Column(length: 20)]
    private ?string $typeChambre = null ;

   

 

    #[ORM\ManyToOne(targetEntity: client::class)]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id_personne')]
    private ?Client $idPersonne;
   
   

  
    #[ORM\ManyToOne(targetEntity: Hotel::class)]
    #[ORM\JoinColumn(name: 'id_hotel', referencedColumnName: 'id_hotel')]
    private ?Hotel $idHotel=null;

  


    public function getRefReservation(): ?int
    {
        return $this->refReservation;
    }

    public function getDureeReservation(): ?float
    {
        return $this->dureeReservation;
    }

    public function setDureeReservation(float $dureeReservation): static
    {
        $this->dureeReservation = $dureeReservation;

        return $this;
    }

    public function getPrixReservation(): ?float
    {
        return $this->prixReservation;
    }

    public function setPrixReservation(float $prixReservation): static
    {
        $this->prixReservation = $prixReservation;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): static
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getTypeChambre(): ?string
    {
        return $this->typeChambre;
    }

    public function setTypeChambre(string $typeChambre): static
    {
        $this->typeChambre = $typeChambre;

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
   
    public function getIdHotel(): ?Hotel
    {
        return $this->idHotel;
    }

    public function setIdHotel(?Hotel $idHotel): static
    {
        $this->idHotel = $idHotel;

        return $this;
    }


  


}
