<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MedecinRepository;
/**
 * @ORM\Entity(repositoryClass="App\Repository\MedecinRepository")
 */
#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $idMedecin = null;

    #[ORM\Column(length: 30)]
    private ?string $nomMedecin ;

    #[ORM\Column(length: 30)]
    private ?string $prenomMedecinMedecin;

    #[ORM\Column]
    private ?int $numeroTelephoneMedecin;

    #[ORM\Column(length: 50)]
    private ?string $addressMedecin;

    #[ORM\Column(length: 50)]
    private ?string $specialiteMedecin;

    public function getIdMedecin(): ?int
    {
        return $this->idMedecin;
    }

    public function getNomMedecin(): ?string
    {
        return $this->nomMedecin;
    }

    public function setNomMedecin(string $nomMedecin): static
    {
        $this->nomMedecin = $nomMedecin;

        return $this;
    }

    public function getPrenomMedecinMedecin(): ?string
    {
        return $this->prenomMedecinMedecin;
    }

    public function setPrenomMedecinMedecin(string $prenomMedecinMedecin): static
    {
        $this->prenomMedecinMedecin = $prenomMedecinMedecin;

        return $this;
    }

    public function getNumeroTelephoneMedecin(): ?int
    {
        return $this->numeroTelephoneMedecin;
    }

    public function setNumeroTelephoneMedecin(int $numeroTelephoneMedecin): static
    {
        $this->numeroTelephoneMedecin = $numeroTelephoneMedecin;

        return $this;
    }

    public function getAddressMedecin(): ?string
    {
        return $this->addressMedecin;
    }

    public function setAddressMedecin(string $addressMedecin): static
    {
        $this->addressMedecin = $addressMedecin;

        return $this;
    }

    public function getSpecialiteMedecin(): ?string
    {
        return $this->specialiteMedecin;
    }

    public function setSpecialiteMedecin(string $specialiteMedecin): static
    {
        $this->specialiteMedecin = $specialiteMedecin;

        return $this;
    }
    public function __toString()
    {
        return $this->nomMedecin;
    }


}
