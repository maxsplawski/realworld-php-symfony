<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestValidator
{
    public function __construct(private readonly ValidatorInterface $validator)
    {

    }

    public function validate(object $source): ?array
    {
        $errors = $this->validator->validate($source);

        if ($errors->count() > 0) {
            $errorMessages = [];

            for ($i = 0; $i <= $errors->count() - 1; $i++) {
                $error = $errors->get($i);
                $errorMessages[$error->getPropertyPath()] = [];
                $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
            }

            return $errorMessages;
        }

        return null;
    }
}
