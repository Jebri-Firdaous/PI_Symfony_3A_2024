<?php

namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RendezVousRepository;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use App\Validator as AcmeAssert;



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
    #[Assert\NotBlank(
        message:'Cette valeur ne doit pas être vide'
    )]
    #[Assert\GreaterThan('now',
    message: 'date superieur de maintenant',
    )]
    #[AcmeAssert\ContainsRVWithSameDoctorInTheSameDate(mode: 'loose', message:'Le docteur a un rendez-vous à ce moment-là')]
    private ?DateTime $dateRendezVous;

<<<<<<< HEAD
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: "lesRendezVous")]
    #[ORM\JoinColumn(name: 'id_personne', referencedColumnName: 'id_personne')]
    #[Assert\NotBlank(
        message:'Cette valeur ne doit pas être vide'
    )]
    public Client $id_personne;
    // private Client $id_personne;
=======
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "lesRendezVous")]
    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'id')]
    #[Assert\NotBlank(
        message:'Cette valeur ne doit pas être vide'
    )]
    public User $id;
    // private User $id;
>>>>>>> 37caec1e37e945f6c482a8a42503aea11ab64dea
    

    #[ORM\ManyToOne(targetEntity: Medecin::class, inversedBy: "rendezVous")]
    #[ORM\JoinColumn(name: 'id_medecin', referencedColumnName: 'id_medecin')]
    #[Assert\NotBlank(
    message:'Medecin ne doit pas être vide'
    )]
    public ?Medecin $id_medecin=null;

  

    

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

<<<<<<< HEAD
    public function getClient(): ?Client
    {
        return $this->id_personne;
=======
    public function getUser(): ?User
    {
        return $this->id;
>>>>>>> 37caec1e37e945f6c482a8a42503aea11ab64dea
    }

    public function setIdPersonne(?User $idPersonne): static
    {
<<<<<<< HEAD
        $this->id_personne = $idPersonne;
=======
        $this->id = $idPersonne;
>>>>>>> 37caec1e37e945f6c482a8a42503aea11ab64dea

        return $this;
    }


}