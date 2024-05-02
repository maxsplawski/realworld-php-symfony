<?php

namespace App\ValueResolver;

use App\Dto\NestedJsonDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NestedJsonValueResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly SerializerInterface&DenormalizerInterface $serializer,
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (!in_array(NestedJsonDtoInterface::class, class_implements($argumentType))) {
            return [];
        }

        return [$this->mapRequestPayload($request, $argumentType)];
    }

    /**
     * @param Request $request
     * @param class-string<NestedJsonDtoInterface> $type
     */
    private function mapRequestPayload(Request $request, string $type): ?object
    {
        if ('' === $data = $request->getContent()) {
            return null;
        }

        try {
            $nestedJsonObjectKey = $type::getNestedJsonObjectKey();

            $decodedData = json_decode($data, true);
            $nestedJsonObject = $decodedData[$nestedJsonObjectKey];

            $payload = $this->serializer->denormalize($nestedJsonObject, $type, 'json');

            $violations = $this->validator->validate($payload);

            if ($violations->count() > 0) {
                throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, implode("\n", array_map(static fn ($e) => $e->getMessage(), iterator_to_array($violations))), new ValidationFailedException($payload, $violations));
            }

            return $payload;
        } catch (NotEncodableValueException $e) {
            throw new HttpException(Response::HTTP_BAD_REQUEST,'Request payload contains invalid json data.', $e);
        }
    }
}
