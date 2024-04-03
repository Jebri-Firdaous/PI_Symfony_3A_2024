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
    private $ref_Rendez_Vous;

    #[ORM\Column]
    private ?DateTime $dateRendezVous;
    
    #[ORM\ManyToOne(targetEntity: Medecin::class, inversedBy: "rendezVous")]
    #[ORM\JoinColumn(name: 'id_medecin', referencedColumnName: 'id_medecin')]
    private ?Medecin $id_medecin;


    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: "lesRendezVous")]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id_personne')]
    public Client $id_personne;
    // private Client $id_personne;

    public function getRefRendezVous(): ?int
    {
        return $this->ref_Rendez_Vous;
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
        return $this->id_medecin;
    }

    public function setIdMedecin(?Medecin $idMedecin): static
    {
        $this->id_medecin = $idMedecin;

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