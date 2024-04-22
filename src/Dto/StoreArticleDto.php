<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class StoreArticleDto
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Type('string')]
        private ?string $title,

        #[Assert\NotNull]
        #[Assert\Type('string')]
        private ?string $body,

        #[Assert\NotNull]
        #[Assert\Type('string')]
        private ?string $description,
    )
    {
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
