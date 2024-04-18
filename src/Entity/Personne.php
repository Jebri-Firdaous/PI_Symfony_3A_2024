<?php
namespace App\Entity;
use repository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonneRepository;
/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonneRepository")
 */
#[ORM\Entity(repositoryClass: PersonneRepository::class)]
// #[ORM\Table(name: "Personne")]
// #[ORM\InheritanceType("JOINED")]
// #[ORM\DiscriminatorColumn(name: "type", type: "string")]
// #[ORM\DiscriminatorMap(["personne" => "Personne", "client" => "Client"])]
class Personne
{   #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected ?int $idPersonne=null;

    #[ORM\Column(length: 30)]
    protected ?string $nomPersonne=null;

    #[ORM\Column(length: 30)]
    protected ?string $prenomPersonne = null;

    #[ORM\Column]
    protected ?int $numeroTelephone= 0;

    #[ORM\Column( length: 50)]
    protected ?string $mailPersonne = null;

    #[ORM\Column( length: 50)]
    protected ?string $mdpPersonne=null;

    #[ORM\Column(length: 255)]
    protected ?string $imagePersonne=null;

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

        return $this;
    }


}