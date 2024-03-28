<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Repository\ParkingRepository;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ParkingRepository")
 */
#[ORM\Entity(repositoryClass: ParkingRepository::class)]
class Parking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idParking;

    
    #[ORM\Column(length: 30)]
    private ?string $nomParking;

    
    #[ORM\Column(length: 100)]
    private ?string $addressParking;

    
    #[ORM\Column]
    private ?float $latitude;

    
    #[ORM\Column]
    private ?float $longitude;

    
    #[ORM\Column]
    private ?int $nombrePlaceMax;

    
    #[ORM\Column]
    private ?int $nombrePlaceOcc;

    
    #[ORM\Column(length: 50)]
    private ?string $etatParking;

    #[ORM\OneToMany(mappedBy: 'idParking', targetEntity: Place::class)]
    private Collection $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
    }

    public function getIdParking(): ?int
    {
        return $this->idParking;
    }

    public function getNomParking(): ?string
    {
        return $this->nomParking;
    }

    public function setNomParking(string $nomParking): static
    {
        $this->nomParking = $nomParking;

        return $this;
    }

    public function getAddressParking(): ?string
    {
        return $this->addressParking;
    }

    public function setAddressParking(string $addressParking): static
    {
        $this->addressParking = $addressParking;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getNombrePlaceMax(): ?int
    {
        return $this->nombrePlaceMax;
    }

    public function setNombrePlaceMax(int $nombrePlaceMax): static
    {
        $this->nombrePlaceMax = $nombrePlaceMax;

        return $this;
    }

    public function getNombrePlaceOcc(): ?int
    {
        return $this->nombrePlaceOcc;
    }

    public function setNombrePlaceOcc(int $nombrePlaceOcc): static
    {
        $this->nombrePlaceOcc = $nombrePlaceOcc;

        return $this;
    }

    public function getEtatParking(): ?string
    {
        return $this->etatParking;
    }

    public function setEtatParking(string $etatParking): static
    {
        $this->etatParking = $etatParking;

        return $this;
    }

    /**
     * @return Collection<int, Place>
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): static
    {
        if (!$this->places->contains($place)) {
            $this->places->add($place);
            $place->setIdParking($this);
        }

        return $this;
    }

    public function removePlace(Place $place): static
    {
        if ($this->places->removeElement($place)) {
            // set the owning side to null (unless already changed)
            if ($place->getIdParking() === $this) {
                $place->setIdParking(null);
            }
        }

        return $this;
    }


}
