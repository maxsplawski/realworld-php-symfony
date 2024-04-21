<?php

namespace App\Service;

use App\Dto\ArticleDto;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SluggerInterface $slugger,
    )
    {
    }

    public function store(ArticleDto $dto): Article
    {
        $article = new Article();

        $article->setTitle($dto->getTitle());
        $article->setSlug($this->slugger->slug($dto->getTitle())->lower());
        $article->setDescription($dto->getDescription());
        $article->setBody($dto->getBody());

        $this->entityManager->persist($article);

        $this->entityManager->flush();

        return $article;
    }
}
