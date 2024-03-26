<?php
namespace App\Entity;
use repository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonneRepository;
/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonneRepository")
 */
#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{   #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idPersonne=null;

    #[ORM\Column(length: 30)]
    private ?string $nomPersonne=null;

    #[ORM\Column(length: 30)]
    private ?string $prenomPersonne = null;

    #[ORM\Column]
    private ?int $numeroTelephone= 0;

    #[ORM\Column( length: 50)]
    private ?string $mailPersonne = null;

    #[ORM\Column( length: 50)]
    private ?string $mdpPersonne=null;

    #[ORM\Column(length: 255)]
    private ?string $imagePersonne=null;
    
    public function __construct( string $nom_personne=null, string $prenom_personne=null, int $numero_telephone=null, string $mail_personne=null, string  $mdp_personne=null, string  $image_personne=null) {
        $this->nom_personne = $nom_personne;
        $this->prenom_personne=$prenom_personne;
        $this->numero_telephone=$numero_telephone;
        $this->mail_personne=$mail_personne;
        $this->mdp_personne=$mdp_personne;
        $this->image_personne= $image_personne;
    }
    

    public function getIdPersonne(): ?int
    {
        return $this->idPersonne;
    }

    public function getNomPersonne(): ?string
    {
        return $this->nomPersonne;
    }

    public function setNomPersonne(string $nomPersonne): static
    {
        $this->nomPersonne = $nomPersonne;

        return $this;
    }

    public function getPrenomPersonne(): ?string
    {
        return $this->prenomPersonne;
    }

    public function setPrenomPersonne(string $prenomPersonne): static
    {
        $this->prenomPersonne = $prenomPersonne;

        return $this;
    }

    public function getNumeroTelephone(): ?int
    {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(int $numeroTelephone): static
    {
        $this->numeroTelephone = $numeroTelephone;

        return $this;
    }

    public function getMailPersonne(): ?string
    {
        return $this->mailPersonne;
    }

    public function setMailPersonne(string $mailPersonne): static
    {
        $this->mailPersonne = $mailPersonne;

        return $this;
    }

    public function getMdpPersonne(): ?string
    {
        return $this->mdpPersonne;
    }

    public function setMdpPersonne(string $mdpPersonne): static
    {
        $this->mdpPersonne = $mdpPersonne;

        return $this;
    }

    public function getImagePersonne(): ?string
    {
        return $this->imagePersonne;
    }

    public function setImagePersonne(string $imagePersonne): static
    {
        $this->imagePersonne = $imagePersonne;

        return $this ;
    }


}
