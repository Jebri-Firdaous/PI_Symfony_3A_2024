<?php

namespace App\Form;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToFileTransformer implements DataTransformerInterface
{
    public function transform($file): ?string
    {
        // Check if the file is null
        if ($file === null) {
            return null;
        }

        // Transform the file object to its string representation
        return $file instanceof File ? $file->getPathname() : null;
    }

    public function reverseTransform($string): ?File
    {
        // Transform the string representation back to a file object
        if ($string === null) {
            return null;
        }

        try {
            return new File($string);
        } catch (\Exception $e) {
            throw new TransformationFailedException(sprintf('An error occurred: %s', $e->getMessage()));
        }
    }
}
