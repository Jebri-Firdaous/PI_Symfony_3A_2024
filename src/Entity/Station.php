<?php

namespace App\Entity;
use Repository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StationRepository;


/**
 * @ORM\Entity(repositoryClass=StationRepository::class)
 */
#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column()]
    private ?int $idStation = null ;

    #[ORM\Column(length:30)]
    private ?string $nomStation = null ;

    #[ORM\Column(length:30)]
    private ?string $adressStation = null ;

    #[ORM\Column(length:50)]
    private ?string $type = null;

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
