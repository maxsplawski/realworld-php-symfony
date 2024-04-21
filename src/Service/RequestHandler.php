<?php

namespace App\Service;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestHandler
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer,
    )
    {
    }

    public function handle(Request $request, string $className): object
    {
        $decodedArray = json_decode($request->getContent(), true);
        $entityParams = $decodedArray[$this->getKeyFromClassName($className)];

        $deserializedEntity = $this->serializer->denormalize($entityParams, $className, 'json');

        $errors = $this->validator->validate($deserializedEntity);

        dump($errors);
        if ($errors->count() > 0) {
            throw new BadRequestHttpException($errors->get(0)->getMessage());
        }

        return $deserializedEntity;
    }

    private function getKeyFromClassName(string $className): string
    {
        return strtolower(substr($className, strrpos($className, '\\') + 1));
    }
}
