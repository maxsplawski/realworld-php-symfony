<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateArticleDto implements NestedJsonDtoInterface
{
    private const NESTED_JSON_OBJECT_KEY = 'article';

    public function __construct(
        #[Assert\Type('string')]
        private ?string $title,

        #[Assert\Type('string')]
        private ?string $body,

        #[Assert\Type('string')]
        private ?string $description,
    )
    {
    }

    public static function getNestedJsonObjectKey(): string
    {
        return self::NESTED_JSON_OBJECT_KEY;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
