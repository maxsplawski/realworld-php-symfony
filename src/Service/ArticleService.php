<?php

namespace App\Service;

use App\Dto\StoreArticleDto;
use App\Dto\UpdateArticleDto;
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

    public function store(StoreArticleDto $dto): Article
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

    public function update(Article $article, UpdateArticleDto $dto): Article
    {
        if ($dto->getTitle() !== null) {
            $article->setTitle($dto->getTitle());
            $article->setSlug($this->slugger->slug($dto->getTitle())->lower());
        }

        if ($dto->getDescription() !== null) {
            $article->setDescription($dto->getDescription());
        }

        if ($dto->getBody() !== null) {
            $article->setBody($dto->getBody());
        }

        $this->entityManager->flush();

        return $article;
    }

    public function delete(Article $article): void
    {
        $this->entityManager->remove($article);

        $this->entityManager->flush();
    }
}
