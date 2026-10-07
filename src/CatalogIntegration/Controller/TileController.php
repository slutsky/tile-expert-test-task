<?php

declare(strict_types=1);

namespace App\CatalogIntegration\Controller;

use App\Catalog\ArticleGatewayInterface;
use App\CatalogIntegration\Dto\ArticleDto;
use App\CatalogIntegration\Dto\ArticleFilterDto;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'CatalogIntegration')]
class TileController extends AbstractController
{
    public function __construct(
        private readonly ArticleGatewayInterface $articleGateway,
    ) {
    }

    #[Route(methods: 'GET', path: '/api/v1/articles/by-filter', format: 'json')]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Get article',
        content: new OA\JsonContent(
            ref: new Model(type: ArticleDto::class),
        )
    )]
    public function getArticle(
        #[MapQueryString]
        ArticleFilterDto $articleFilter,
    ): JsonResponse {
        $article = $this->articleGateway->getArticle(
            $articleFilter->factory,
            $articleFilter->collection,
            $articleFilter->article,
        );

        $tile = new ArticleDto(
            $article->priceUSE,
            $article->collection->factory->url,
            $article->collection->url,
            $article->url,
        );

        return $this->json($tile);
    }
}
