<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\ArticleService;
use App\Service\RequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/articles')]
class ArticleController extends AbstractController
{
    public function __construct(
        private readonly RequestHandler $requestHandler,
        private readonly ArticleService $articleService,
    )
    {
    }

    #[Route('', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $deserializedArticle = $this->requestHandler->handle($request, Article::class);

        $article = $this->articleService->store($deserializedArticle);

        return $this->json([
            'article' => $article,
        ], 201);
    }
}
