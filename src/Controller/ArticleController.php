<?php

namespace App\Controller;

use App\Dto\StoreArticleDto;
use App\Dto\UpdateArticleDto;
use App\Entity\Article;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/articles')]
class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleService $articleService,
    )
    {
    }

    #[Route('/{slug}', methods: ['GET'])]
    public function show(Article $article): JsonResponse
    {
        return $this->json([
            'article' => $article,
        ]);
    }

    #[Route('', methods: ['POST'])]
    public function store(#[MapRequestPayload] StoreArticleDto $dto): JsonResponse
    {
        $article = $this->articleService->store($dto);

        return $this->json([
            'article' => $article,
        ], 201);
    }

    #[Route('/{slug}', methods: ['PUT'])]
    public function update(
        #[MapRequestPayload] UpdateArticleDto $dto,
        Article $article,
    ): JsonResponse
    {
        $updatedArticle = $this->articleService->update($article, $dto);

        return $this->json([
            'article' => $updatedArticle,
        ]);
    }

    #[Route('/{slug}', methods: ['DELETE'])]
    public function delete(Article $article): JsonResponse
    {
        $this->articleService->delete($article);

        return $this->json(null, 204);
    }
}
