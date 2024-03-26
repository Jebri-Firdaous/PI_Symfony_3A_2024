<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parking
 *
 * @ORM\Table(name="parking")
 * @ORM\Entity
 */
class Parking
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_parking", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idParking;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_parking", type="string", length=30, nullable=false)
     */
    private $nomParking;

    /**
     * @var string
     *
     * @ORM\Column(name="address_parking", type="string", length=100, nullable=false)
     */
    private $addressParking;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $longitude;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_place_max", type="integer", nullable=false)
     */
    private $nombrePlaceMax;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_place_occ", type="integer", nullable=false)
     */
    private $nombrePlaceOcc;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_parking", type="string", length=50, nullable=false)
     */
    private $etatParking;

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


}
