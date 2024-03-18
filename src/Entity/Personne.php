<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personne
 *
 * @ORM\Table(name="personne")
 * @ORM\Entity
 */
class Personne
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_personne", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPersonne;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_personne", type="string", length=30, nullable=false)
     */
    private $nomPersonne;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_personne", type="string", length=30, nullable=false)
     */
    private $prenomPersonne;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_telephone", type="integer", nullable=false)
     */
    private $numeroTelephone;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_personne", type="string", length=50, nullable=false)
     */
    private $mailPersonne;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp_personne", type="string", length=50, nullable=false)
     */
    private $mdpPersonne;

    /**
     * @var string
     *
     * @ORM\Column(name="image_personne", type="string", length=255, nullable=false)
     */
    private $imagePersonne;

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
