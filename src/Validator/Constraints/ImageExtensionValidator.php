<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ImageExtensionValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ImageExtension) {
            throw new UnexpectedTypeException($constraint, ImageExtension::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $allowedExtensions = $constraint->getAllowedExtensions();
        $extension = strtolower(pathinfo($value, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions, true)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ file }}', $value)
                ->setParameter('{{ extensions }}', implode(', ', $allowedExtensions))
                ->addViolation();
        }
    }
}
