<?php

namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HotelRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HotelRepository")
 */

#[ORM\Entity(repositoryClass: HotelRepository::class)]

class Hotel
{
    

     #[ORM\Id]
     #[ORM\GeneratedValue]
     #[ORM\Column]

    private ?int  $idHotel = null;


     #[ORM\Column(length: 15)]
     #[Assert\NotBlank(message:"Le nom  de hotel est requise")]

    private  ?string $nomHotel = null;


     #[ORM\Column(length: 30)]
     #[Assert\NotBlank(message:"L'adress  de hotel est requise")]

     private  ?string $adressHotel = null;
    
    
     #[ORM\Column]
     #[Assert\NotBlank(message:"Le prix normal  de hotel est requise")]
     #[Assert\Positive(message: "Le prix de type normal doit être un nombre entier positif")]

     #[Assert\Type(type: "float", message: "Le prix de type normal doit être un nombre")]
    private  ?float $prix1 = null;

   
    #[ORM\Column]
    #[Assert\NotBlank(message:"Le prix standard  de hotel est requise")]
    #[Assert\Positive(message: "Le prix de type standard doit être un nombre entier positif")]

    #[Assert\Type(type: "float", message: "Le prix de type standard doit être un nombre")]

    private ?float $prix2 = null;

    #[ORM\Column]
    #[Assert\Positive(message: "Le prix de type luxe doit être un nombre entier positif")]

    #[Assert\Type(type: "float", message: "Le prix de type luxe doit être un nombre")]

    #[Assert\NotBlank(message:"Le prix luxe  de hotel est requise")]

    private ?float  $prix3 = null;

  
    #[ORM\Column]
    #[Assert\NotBlank(message:"Le numero de chombre de type  normal  de hotel est requise")]
    #[Assert\Positive(message: "La numero de chombre de type  normal doit être un nombre entier positif")]

    private ?int $numero1 = null ;
   

    #[ORM\Column]
    #[Assert\Positive(message: "La numero de chombre de type  standard doit être un nombre entier positif")]

    #[Assert\NotBlank(message:"Le numero de chombre de type  standard  de hotel est requise")]

    private ?int $numero2 = null ;

  
    #[ORM\Column]
    #[Assert\Positive(message: "La numero de chombre de type  luxe doit être un nombre entier positif")]

    #[Assert\NotBlank(message:"Le numero de chombre de type  luxe  de hotel est requise")]

    private ?int $numero3 = null ;

    public function getIdHotel(): ?int
    {
        return $this->idHotel;
    }

    public function getNomHotel(): ?string
    {
        return $this->nomHotel;
    }

    public function setNomHotel(string $nomHotel): static
    {
        $this->nomHotel = $nomHotel;

        return $this;
    }

    public function getAdressHotel(): ?string
    {
        return $this->adressHotel;
    }

    public function setAdressHotel(string $adressHotel): static
    {
        $this->adressHotel = $adressHotel;

        return $this;
    }

    public function getPrix1(): ?float
    {
        return $this->prix1;
    }

    public function setPrix1(float $prix1): static
    {
        $this->prix1 = $prix1;

        return $this;
    }

    public function getPrix2(): ?float
    {
        return $this->prix2;
    }

    public function setPrix2(float $prix2): static
    {
        $this->prix2 = $prix2;

        return $this;
    }

    public function getPrix3(): ?float
    {
        return $this->prix3;
    }

    public function setPrix3(float $prix3): static
    {
        $this->prix3 = $prix3;

        return $this;
    }

    public function getNumero1(): ?int
    {
        return $this->numero1;
    }

    public function setNumero1(int $numero1): static
    {
        $this->numero1 = $numero1;

        return $this;
    }

    public function getNumero2(): ?int
    {
        return $this->numero2;
    }

    public function setNumero2(int $numero2): static
    {
        $this->numero2 = $numero2;

        return $this;
    }

    public function getNumero3(): ?int
    {
        return $this->numero3;
    }

    public function setNumero3(int $numero3): static
    {
        $this->numero3 = $numero3;

        return $this;
    }

   /* public function __toString(): string
    {
        return $this->getNomHotel() ?? 'Unnamed Hotel';
    }
    */

    public function __toString(): string
    {
        return $this->getNomHotel() ?? 'Unnamed Hotel';
    }

}
