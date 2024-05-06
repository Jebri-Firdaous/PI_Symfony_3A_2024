<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ImageExtension extends Constraint
{
    public $message = 'L\'extension du fichier "{{ file }}" n\'est pas valide. Les extensions autorisées sont : {{ extensions }}.';

    public array $allowedExtensions = [];

    public function __construct($options = null)
    {
        parent::__construct($options);

        if (empty($this->allowedExtensions)) {
            throw new \InvalidArgumentException('Vous devez spécifier au moins une extension autorisée.');
        }
    }

    public function getAllowedExtensions(): array
    {
        return $this->allowedExtensions;
    }
}