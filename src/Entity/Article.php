<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_article", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_article", type="string", length=30, nullable=false)
     */
    private $nomArticle;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_article", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixArticle;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite_article", type="integer", nullable=false)
     */
    private $quantiteArticle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_article", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $typeArticle = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_article", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $descriptionArticle = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo_article", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $photoArticle = 'NULL';

    public function getIdArticle(): ?int
    {
        return $this->idArticle;
    }

    public function getNomArticle(): ?string
    {
        return $this->nomArticle;
    }

    public function setNomArticle(string $nomArticle): static
    {
        $this->nomArticle = $nomArticle;

        return $this;
    }

    public function getPrixArticle(): ?float
    {
        return $this->prixArticle;
    }

    public function setPrixArticle(float $prixArticle): static
    {
        $this->prixArticle = $prixArticle;

        return $this;
    }

    public function getQuantiteArticle(): ?int
    {
        return $this->quantiteArticle;
    }

    public function setQuantiteArticle(int $quantiteArticle): static
    {
        $this->quantiteArticle = $quantiteArticle;

        return $this;
    }

    public function getTypeArticle(): ?string
    {
        return $this->typeArticle;
    }

    public function setTypeArticle(?string $typeArticle): static
    {
        $this->typeArticle = $typeArticle;

        return $this;
    }

    public function getDescriptionArticle(): ?string
    {
        return $this->descriptionArticle;
    }

    public function setDescriptionArticle(?string $descriptionArticle): static
    {
        $this->descriptionArticle = $descriptionArticle;

        return $this;
    }

    public function getPhotoArticle(): ?string
    {
        return $this->photoArticle;
    }

    public function setPhotoArticle(?string $photoArticle): static
    {
        $this->photoArticle = $photoArticle;

        return $this;
    }


}
