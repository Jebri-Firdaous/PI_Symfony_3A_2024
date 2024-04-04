<?php
// src/Validator/ContainsAlphanumericValidator.php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use App\Entity\RendezVous;
use Doctrine\ORM\EntityManagerInterface;

class ContainsRVWithSameDoctorInTheSameDateValidator extends ConstraintValidator
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
{
    // Assuming $value is the date of the rendezvous
   

    // Check if idMedecin is not null before proceeding
    dump($this->context->getObject()->getIdMedecin());
    if ($this->context->getObject()->getIdMedecin() === null) {
        // Handle the case where idMedecin is null, e.g., skip validation or add a violation
        // For example, to skip validation:
        return;

        // Or, to add a violation for the idMedecin field:
        // $this->context->buildViolation('Medecin must not be null.')
        //     ->atPath('idMedecin')
        //     ->addViolation();
    }
    $medecinId = $this->context->getObject()->getIdMedecin();
    $existingRendezvous = $this->entityManager->getRepository(RendezVous::class)
        ->findOneBy([
            'id_medecin' => $medecinId,
            'dateRendezVous' => $value,
        ]);

    if ($existingRendezvous) {
        $this->context->buildViolation($constraint->message)
            ->atPath('dateRendezVous')
            ->addViolation();
    }
}

}