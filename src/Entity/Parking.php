<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParkingRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParkingRepository")
 */
#[ORM\Entity(repositoryClass: ParkingRepository::class)]
class Parking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idParking;

    
    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:'Ce champ est obligatoire!')]
    #[Assert\Length(min:3, minMessage:'doit etre >=3', max:10, maxMessage:'doit etre <=10')]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]*$/',
        message: "Le nom ne peut contenir que des lettres."
        )]
    private ?string $nomParking;
    
    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message:'Ce champ est obligatoire!')]
    #[Assert\Length(min:5, minMessage:'doit etre >=5', max:15, maxMessage:'doit etre <=15')]
    #[Assert\Type("string")]
    private ?string $addressParking;

    
    #[ORM\Column]
    #[Assert\NotBlank(message:'Ce champ est obligatoire!')]
    #[Assert\Type("float", message:'doit contenir que des chiffre')]
    private ?float $latitude;

    
    #[ORM\Column]
    #[Assert\NotBlank(message:'Ce champ est obligatoire!')]
    #[Assert\Type("float", message:'doit contenir que des chiffre')]
    private ?float $longitude;

    
    #[ORM\Column]
    #[Assert\NotBlank(message:'Ce champ est obligatoire!')]
    #[Assert\LessThan(value:100, message:'doit etre <50')]
    // #[Assert\GreaterThanOrEqual(propertyPath: 'nombrePlaceOcc', message:'doit etre >Nombre de places')]
    #[Assert\Positive(message:'doit etre positive')]
    #[Assert\Type("integer", message:'doit contenir que des chiffre')]
    // #[Assert\Callback(callback: 'validateNombrePlaceMax')]
    private ?int $nombrePlaceMax;
    
    public function validateNombrePlaceMax($object, ExecutionContextInterface $context): void
    {
        if (!$object instanceof Parking) {
            return; // If not a Parking entity, skip validation
        }
        $nombrePlaceMax = $object->getNombrePlaceMax();
        $idParking = $object->getIdParking();

        $rep = $this->entityManager->getRepository(Parking::class);
        $nb = $rep->nbPlace($idParking);

        // Custom validation logic
        if ($nombrePlaceMax !== null && $nombrePlaceMax < $nb) {
            $context->buildViolation('The value should be a number.')->atPath('nombrePlaceMax')->addViolation();
        }
    }

    #[ORM\Column]
    private ?int $nombrePlaceOcc;

    private EntityManagerInterface $entityManager;
    
    #[ORM\Column(length: 50)]
    private ?string $etatParking;

    #[ORM\OneToMany(mappedBy: 'idParking', targetEntity: Place::class)]
    private Collection $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
    }

    public function getIdParking(): ?int
    {
        return $this->idParking;
    }

    public function getNomParking(): ?string
    {
        return $this->nomParking;
    }

    public function setNomParking(string $nomParking): static
    {
        $this->nomParking = $nomParking;

        return $this;
    }

    public function getAddressParking(): ?string
    {
        return $this->addressParking;
    }

    public function setAddressParking(string $addressParking): static
    {
        $this->addressParking = $addressParking;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getNombrePlaceMax(): ?int
    {
        return $this->nombrePlaceMax;
    }

    public function setNombrePlaceMax(int $nombrePlaceMax): static
    {
        $this->nombrePlaceMax = $nombrePlaceMax;

        return $this;
    }

    public function getNombrePlaceOcc(): ?int
    {
        return $this->nombrePlaceOcc;
    }

    public function setNombrePlaceOcc(int $nombrePlaceOcc): static
    {
        $this->nombrePlaceOcc = $nombrePlaceOcc;

        return $this;
    }

    public function getEtatParking(): ?string
    {
        return $this->etatParking;
    }

    public function setEtatParking(string $etatParking): static
    {
        $this->etatParking = $etatParking;

        return $this;
    }

    /**
     * @return Collection<int, Place>
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): static
    {
        if (!$this->places->contains($place)) {
            $this->places->add($place);
            $place->setIdParking($this);
        }

        return $this;
    }

    public function removePlace(Place $place): static
    {
        if ($this->places->removeElement($place)) {
            // set the owning side to null (unless already changed)
            if ($place->getIdParking() === $this) {
                $place->setIdParking(null);
            }
        }

        return $this;
    }


}
