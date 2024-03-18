<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;
use App\Entity\Parking;

/**
 * Place
 *
 * @ORM\Table(name="place", indexes={@ORM\Index(name="fk_user", columns={"id_user"}), @ORM\Index(name="fk_parking", columns={"id_parking"})})
 * @ORM\Entity
 */
class Place
{
    /**
     * @var int
     *
     * @ORM\Column(name="ref_place", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $refPlace;

    /**
     * @var int
     *
     * @ORM\Column(name="num_place", type="integer", nullable=false)
     */
    private $numPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="type_place", type="string", length=255, nullable=false)
     */
    private $typePlace;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=30, nullable=false)
     */
    private $etat;

    /**
     * @var \Parking
     *
     * @ORM\ManyToOne(targetEntity="Parking")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_parking", referencedColumnName="id_parking")
     * })
     */
    private $idParking;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_personne")
     * })
     */
    private $idUser;

    public function getRefPlace(): ?int
    {
        return $this->refPlace;
    }

    public function getNumPlace(): ?int
    {
        return $this->numPlace;
    }

    public function setNumPlace(int $numPlace): static
    {
        $this->numPlace = $numPlace;

        return $this;
    }

    public function getTypePlace(): ?string
    {
        return $this->typePlace;
    }

    public function setTypePlace(string $typePlace): static
    {
        $this->typePlace = $typePlace;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdParking(): ?Parking
    {
        return $this->idParking;
    }

    public function setIdParking(?Parking $idParking): static
    {
        $this->idParking = $idParking;

        return $this;
    }

    public function getIdUser(): ?Client
    {
        return $this->idUser;
    }

    public function setIdUser(?Client $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }


}
