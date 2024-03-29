<?php

namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RendezVousRepository;
use DateTime;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RendezVousRepository")
 * @ORM\Table(name="`rendez-vous`")
 */

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "ref_rendez_vous")]
    private $refRendezVous;

    #[ORM\Column]
    private ?DateTime $dateRendezVous;
    
    #[ORM\ManyToOne(targetEntity: Medecin::class)]
    #[ORM\JoinColumn(name: 'id_medecin', referencedColumnName: 'id_medecin')]
    private ?Medecin $idMedecin;


    // #[ORM\ManyToOne(inversedBy: 'lesRendezVousClients')]
    // #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: "LesRendezVous")]
    // #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id_personne')]
    private Client $id_personne;

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

    public function getClient(): ?Client
    {
        return $this->id_personne;
    }

    public function setIdPersonne(?Client $idPersonne): static
    {
        $this->id_personne = $idPersonne;

        return $this;
    }


}