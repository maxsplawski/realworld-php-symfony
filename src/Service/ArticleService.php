<?php

namespace App\Service;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class ArticleService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function store(Article $article): Article
    {
        $this->entityManager->persist($article);

        $this->entityManager->flush();

        return $article;
    }
}
