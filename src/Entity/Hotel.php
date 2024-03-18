<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hotel
 *
 * @ORM\Table(name="hotel")
 * @ORM\Entity
 */
class Hotel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_hotel", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idHotel;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_hotel", type="string", length=30, nullable=false)
     */
    private $nomHotel;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_hotel", type="string", length=50, nullable=false)
     */
    private $adressHotel;

    /**
     * @var float
     *
     * @ORM\Column(name="prix1", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix1;

    /**
     * @var float
     *
     * @ORM\Column(name="prix2", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix2;

    /**
     * @var float
     *
     * @ORM\Column(name="prix3", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix3;

    /**
     * @var int
     *
     * @ORM\Column(name="numero1", type="integer", nullable=false)
     */
    private $numero1;

    /**
     * @var int
     *
     * @ORM\Column(name="numero2", type="integer", nullable=false)
     */
    private $numero2;

    /**
     * @var int
     *
     * @ORM\Column(name="numero3", type="integer", nullable=false)
     */
    private $numero3;

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


}
