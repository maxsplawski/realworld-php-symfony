<?php

namespace App\Controller;

use App\Dto\ArticleDto;
use App\Entity\Article;
use App\Serializer\RequestSerializer;
use App\Service\ArticleService;
use App\Validator\RequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/articles', format: 'json')]
class ArticleController extends AbstractController
{
    public function __construct(
        private readonly RequestSerializer $requestSerializer,
        private readonly RequestValidator $requestValidator,
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
    public function store(Request $request): JsonResponse
    {
        $deserializedDto = $this->requestSerializer->serialize($request, 'article', ArticleDto::class);

        $errors = $this->requestValidator->validate($deserializedDto);

        if ($errors) {
            return $this->json([
                'errors' => $errors,
            ], 422);
        }

        $article = $this->articleService->store($deserializedDto);

        return $this->json([
            'article' => $article,
        ], 201);
    }
}
