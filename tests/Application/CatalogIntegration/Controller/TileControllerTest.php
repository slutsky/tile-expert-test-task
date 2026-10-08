<?php

declare(strict_types=1);

namespace App\Tests\Application\CatalogIntegration\Controller;

use App\Catalog\ExceptionInterface;
use App\CatalogIntegration\Controller\TileController;
use App\CatalogIntegration\Dto\ArticleDto;
use App\CatalogIntegration\Dto\ArticleFilterDto;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

#[CoversClass(TileController::class)]
#[CoversClass(ArticleFilterDto::class)]
#[CoversClass(ArticleDto::class)]
class TileControllerTest extends WebTestCase
{
    public function testGetArticle(): void
    {
        $client = static::createClient();

        $container = static::getContainer();
        $container->set(
            'app.catalog_integration.client',
            $this->createConfiguredStub(HttpClientInterface::class, [
                'request' => $this->createConfiguredStub(ResponseInterface::class, [
                    'getContent' => file_get_contents(__DIR__.'/../Resources/responses/articles_success_response.json'),
                ]),
            ]),
        );

        $client->jsonRequest('GET', '/api/v1/articles/by-filter?'.http_build_query([
            'factory' => 'marca-corona',
            'collection' => 'arteseta',
            'article' => 'k263-arteseta-camoscio-s000628660',
        ]));

        self::assertResponseIsSuccessful();
    }

    public function testGetArticleWithExceptionFromCatalog(): void
    {
        $client = static::createClient();

        $container = static::getContainer();

        $exception = $this->createStub(ExceptionInterface::class);
        $response = $this->createStub(ResponseInterface::class);
        $response->method('getContent')->willThrowException($exception);

        $container->set(
            'app.catalog_integration.client',
            $this->createConfiguredStub(HttpClientInterface::class, [
                'request' => $response,
            ]),
        );

        $client->jsonRequest('GET', '/api/v1/articles/by-filter?'.http_build_query([
            'factory' => 'marca-corona',
            'collection' => 'arteseta',
            'article' => 'k263-arteseta-camoscio-s000628660',
        ]));

        self::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
