<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Form\FormInterface;

class ErrorService
{
    public static function extractFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true, false) as $error) {
            $errors[] = $error->current()->getMessage();
        }

        return $errors;
    }

    public static function getFirstError(FormInterface $form): string
    {
        return self::extractFormErrors($form)[0] ?? '';
    }
}
