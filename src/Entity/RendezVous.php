<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Medecin;
use App\Entity\Client;

/**
 * RendezVous
 *
 * @ORM\Table(name="rendez-vous", indexes={@ORM\Index(name="id_personne", columns={"id_personne"}), @ORM\Index(name="id_medecin", columns={"id_medecin"})})
 * @ORM\Entity
 */
class RendezVous
{
    /**
     * @var int
     *
     * @ORM\Column(name="ref_rendez_vous", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $refRendezVous;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_rendez_vous", type="datetime", nullable=false)
     */
    private $dateRendezVous;

    /**
     * @var \Medecin
     *
     * @ORM\ManyToOne(targetEntity="Medecin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_medecin", referencedColumnName="id_medecin")
     * })
     */
    private $idMedecin;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     * })
     */
    private $idPersonne;

    public function getRefRendezVous(): ?int
    {
        return $this->refRendezVous;
    }

    public function getDateRendezVous(): ?\DateTimeInterface
    {
        return $this->dateRendezVous;
    }

    public function setDateRendezVous(\DateTimeInterface $dateRendezVous): static
    {
        $this->dateRendezVous = $dateRendezVous;

        return $this;
    }

    public function getIdMedecin(): ?Medecin
    {
        return $this->idMedecin;
    }

    public function setIdMedecin(?Medecin $idMedecin): static
    {
        $this->idMedecin = $idMedecin;

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


}
