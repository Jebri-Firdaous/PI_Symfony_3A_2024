<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medecin
 *
 * @ORM\Table(name="medecin")
 * @ORM\Entity
 */
class Medecin
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_medecin", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMedecin;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_medecin", type="string", length=30, nullable=false)
     */
    private $nomMedecin;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_medecin_medecin", type="string", length=30, nullable=false)
     */
    private $prenomMedecinMedecin;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_telephone_medecin", type="integer", nullable=false)
     */
    private $numeroTelephoneMedecin;

    /**
     * @var string
     *
     * @ORM\Column(name="address_medecin", type="string", length=50, nullable=false)
     */
    private $addressMedecin;

    /**
     * @var string
     *
     * @ORM\Column(name="specialite_medecin", type="string", length=50, nullable=false)
     */
    private $specialiteMedecin;

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


}
