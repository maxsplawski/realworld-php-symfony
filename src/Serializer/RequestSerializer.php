<?php

namespace App\Serializer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class RequestSerializer
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    public function serialize(Request $request, string $decodedEntityParamsKey, string $className): object
    {
        $decodedArray = json_decode($request->getContent(), true);
        $entityParams = $decodedArray[$decodedEntityParamsKey];

        return $this->serializer->denormalize($entityParams, $className, 'json');
    }
}
