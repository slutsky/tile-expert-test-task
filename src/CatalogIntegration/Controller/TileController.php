<?php

declare(strict_types=1);

namespace App\CatalogIntegration\Controller;

use App\Catalog\ArticleGatewayInterface;
use App\CatalogIntegration\Dto\ArticleDto;
use App\CatalogIntegration\Dto\ArticleFilterDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

class TileController extends AbstractController
{
    public function __construct(
        private readonly ArticleGatewayInterface $articleGateway,
    ) {
    }

    #[Route(methods: 'GET', path: '/api/v1/tiles')]
    public function getTilesByArticle(
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
