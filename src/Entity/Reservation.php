<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="id_hotel", columns={"id_hotel"}), @ORM\Index(name="reservation_ibfk_2", columns={"id_personne"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="ref_reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $refReservation;

    /**
     * @var float
     *
     * @ORM\Column(name="duree_reservation", type="float", precision=10, scale=0, nullable=false)
     */
    private $dureeReservation;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_reservation", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixReservation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reservation", type="date", nullable=false)
     */
    private $dateReservation;

    /**
     * @var string
     *
     * @ORM\Column(name="type_chambre", type="string", length=0, nullable=false)
     */
    private $typeChambre;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     * })
     */
    private $idPersonne;

    /**
     * @var \Hotel
     *
     * @ORM\ManyToOne(targetEntity="Hotel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_hotel", referencedColumnName="id_hotel")
     * })
     */
    private $idHotel;

    public function getRefReservation(): ?int
    {
        return $this->refReservation;
    }

    public function getDureeReservation(): ?float
    {
        return $this->dureeReservation;
    }

    public function setDureeReservation(float $dureeReservation): static
    {
        $this->dureeReservation = $dureeReservation;

        return $this;
    }

    public function getPrixReservation(): ?float
    {
        return $this->prixReservation;
    }

    public function setPrixReservation(float $prixReservation): static
    {
        $this->prixReservation = $prixReservation;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): static
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getTypeChambre(): ?string
    {
        return $this->typeChambre;
    }

    public function setTypeChambre(string $typeChambre): static
    {
        $this->typeChambre = $typeChambre;

        return $this;
    }

    public function getIdPersonne(): ?Client
    {
        return $this->idPersonne;
    }

    public function setIdPersonne(?Client $idPersonne): static
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }

    public function getIdHotel(): ?Hotel
    {
        return $this->idHotel;
    }

    public function setIdHotel(?Hotel $idHotel): static
    {
        $this->idHotel = $idHotel;

        return $this;
    }


}
