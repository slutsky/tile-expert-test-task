<?php

declare(strict_types=1);

namespace App\CatalogIntegration\Controller;

use App\Catalog\ArticleGatewayInterface;
use App\Catalog\ExceptionInterface;
use App\CatalogIntegration\Dto\ArticleDto;
use App\CatalogIntegration\Dto\ArticleFilterDto;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'Catalog')]
class TileController extends AbstractController
{
    public function __construct(
        private readonly ArticleGatewayInterface $articleGateway,
        private readonly LoggerInterface $logger,
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
    #[OA\Response(
        response: Response::HTTP_UNPROCESSABLE_ENTITY,
        description: 'Failure to get article',
        content: new OA\JsonContent(ref: '#/components/schemas/ExceptionResponse'),
    )]
    public function getArticle(
        #[MapQueryString]
        ArticleFilterDto $articleFilter,
    ): JsonResponse {
        try {
            $article = $this->articleGateway->getArticle(
                $articleFilter->factory,
                $articleFilter->collection,
                $articleFilter->article,
            );
        } catch (ExceptionInterface $exception) {
            $this->logger->error('Failure to get article from catalog.', [
                'exception' => $exception,
            ]);

            throw new UnprocessableEntityHttpException('Failure to get article.', $exception);
        }

        $tile = new ArticleDto(
            $article->priceUSE,
            $article->collection->factory->url,
            $article->collection->url,
            $article->url,
        );

        return $this->json($tile);
    }
}
