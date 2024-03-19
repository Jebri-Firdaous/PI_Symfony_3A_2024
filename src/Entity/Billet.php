<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Billet
 *
 * @ORM\Table(name="billet", indexes={@ORM\Index(name="id_station", columns={"station"}), @ORM\Index(name="indexIdPersonne", columns={"id_personne"})})
 * @ORM\Entity
 */
class Billet
{
    /**
     * @var int
     *
     * @ORM\Column(name="ref_voyage", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $refVoyage;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_voyage", type="string", length=30, nullable=false)
     */
    private $destinationVoyage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_depart", type="datetime", nullable=false)
     */
    private $dateDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=50, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="duree", type="string", length=40, nullable=false)
     */
    private $duree;

    /**
     * @var \Station
     *
     * @ORM\ManyToOne(targetEntity="Station")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="station", referencedColumnName="id_station")
     * })
     */
    private $station;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     * })
     */
    private $idPersonne;

    public function getRefVoyage(): ?int
    {
        return $this->refVoyage;
    }

    public function getDestinationVoyage(): ?string
    {
        return $this->destinationVoyage;
    }

    public function setDestinationVoyage(string $destinationVoyage): static
    {
        $this->destinationVoyage = $destinationVoyage;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }


    public function setStation(?Station $station): static
    {
        $this->station = $station;

        return $this;
    }


    public function setIdPersonne(?Client $idPersonne): static
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function getIdPersonne(): ?Client
    {
        return $this->idPersonne;
    }


}
