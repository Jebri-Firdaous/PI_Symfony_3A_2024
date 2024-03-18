<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Station
 *
 * @ORM\Table(name="station")
 * @ORM\Entity
 */
class Station
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_station", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStation;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_station", type="string", length=30, nullable=false)
     */
    private $nomStation;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_station", type="string", length=30, nullable=false)
     */
    private $adressStation;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    public function getIdStation(): ?int
    {
        return $this->idStation;
    }

    public function getNomStation(): ?string
    {
        return $this->nomStation;
    }

    public function setNomStation(string $nomStation): static
    {
        $this->nomStation = $nomStation;

        return $this;
    }

    public function getAdressStation(): ?string
    {
        return $this->adressStation;
    }

    public function setAdressStation(string $adressStation): static
    {
        $this->adressStation = $adressStation;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }


}
