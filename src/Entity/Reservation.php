<?php

namespace App\Entity;
use App\Entity\Hotel;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Repository\ReservationRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
#[ORM\Entity(repositoryClass: ReservationRepository::class)]

class Reservation
{
   

     #[ORM\Id]
     #[ORM\GeneratedValue]
     #[ORM\Column]
    
    private ?int $refReservation = null;

   
    #[ORM\Column]
    #[Assert\NotBlank(message: "La durée de la réservation est requise")]
    #[Assert\PositiveOrZero(message: "La durée doit être un nombre positif ou nul")]

    private ?float $dureeReservation = null;

   

     #[ORM\Column]
 
    private ?float  $prixReservation = null ;

  
    

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: "La date de la réservation est requise")]
    #[Assert\Type(type: "\DateTimeInterface", message: "La date de la réservation doit être une instance de DateTimeInterface")]
    #[Assert\GreaterThan("today", message: "La date de la réservation doit être postérieure à la date actuelle")]
    private ?\DateTime $dateReservation;
    

 
     #[ORM\Column]
     #[Assert\NotBlank(message:"Le type de la réservation est requise")]
    private ?string $typeChambre = null ;

   

 

   
   

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "lesReservatoin")]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id')]
    #[Assert\NotBlank(
        message:'Cette valeur ne doit pas être vide'
    )]
    public User $id;
    // private User $id;
  

    #[ORM\ManyToOne(targetEntity: Hotel::class)]
    #[ORM\JoinColumn(name: 'id_hotel', referencedColumnName: 'id_hotel')]
    private ?Hotel $idHotel = null;
  
  
 
   /* private $hotels;

    public function __construct()
    {
        $this->hotels = new ArrayCollection();
    }

    public function getHotels(): Collection
    {
        return $this->hotels;
    }

    public function addHotel(Hotel $hotel): self
    {
        if (!$this->hotels->contains($hotel)) {
            $this->hotels[] = $hotel;
        }

        return $this;
    }

    public function removeHotel(Hotel $hotel): self
    {
        $this->hotels->removeElement($hotel);

        return $this;
    }
*/
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

    public function getUser(): ?User
    {
        return $this->id;
    }
    

    public function setIdPersonne(?User $idPersonne): static
    {
        $this->id = $idPersonne;

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
