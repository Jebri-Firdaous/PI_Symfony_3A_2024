<?php

namespace App\Entity;
use Repository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StationRepository;
use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\Length(min:6, minMessage:"nom Non valide !")]
    #[Assert\Regex(
             pattern:"/^(?=.*\d).*station.*$/i",
             message:"Le nom de la station doit contenir le mot 'station' et au moins un chiffre")]
    #[Assert\NotBlank(message:"nom station est obligatoire")]
    private ?string $nomStation = null ;

    #[ORM\Column(length:30)]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z]+$/",
        message:"L'adresse de la station doit contenir uniquement des caractères alphabétiques")]
        #[Assert\NotBlank(message:"L'adresse  est obligatoire")]

    private ?string $adressStation = null ;

    #[ORM\Column(length:50)]
    #[Assert\NotBlank(message:"Le type est obligatoire")]

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
