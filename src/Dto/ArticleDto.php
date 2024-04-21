<?php

namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;


readonly class ArticleDto
{
    public function __construct(
        #[Assert\NotNull] private ?string $title,
        #[Assert\NotNull] private ?string $body,
        #[Assert\NotNull] private ?string $description,
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
