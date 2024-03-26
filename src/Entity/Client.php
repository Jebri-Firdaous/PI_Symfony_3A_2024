<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends Personne
{
    #[ORM\Column(length: 30, nullable: true)]
    private ?string $genre = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $age = null;

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;
        return $this;
    }
}
