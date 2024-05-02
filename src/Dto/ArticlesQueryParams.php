<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class ArticlesQueryParams
{
    public function __construct(
        #[Assert\Type('integer')]
        private int $limit = 20,

        #[Assert\Type('integer')]
        private int $offset = 0,
    )
    {
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
