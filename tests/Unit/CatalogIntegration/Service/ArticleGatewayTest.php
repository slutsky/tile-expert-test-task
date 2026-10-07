<?php

declare(strict_types=1);

namespace App\Tests\Unit\CatalogIntegration\Service;

use App\Catalog\Article;
use App\Catalog\Articles;
use App\Catalog\Collection;
use App\Catalog\Factory;
use App\CatalogIntegration\Exception\DeserializationException;
use App\CatalogIntegration\Exception\HttpException;
use App\CatalogIntegration\Exception\NotFoundException;
use App\CatalogIntegration\Service\ArticleGateway;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface as HttpExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

#[CoversClass(ArticleGateway::class)]
#[CoversClass(DeserializationException::class)]
#[CoversClass(HttpException::class)]
#[CoversClass(NotFoundException::class)]
class ArticleGatewayTest extends TestCase
{
    private MockObject&HttpClientInterface $client;
    private MockObject&SerializerInterface $serializer;

    private ArticleGateway $articleGateway;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(HttpClientInterface::class);
        $this->serializer = $this->createMock(SerializerInterface::class);

        $this->articleGateway = new ArticleGateway(
            $this->client,
            $this->serializer,
        );
    }

    #[\Override]
    protected function tearDown(): void
    {
        parent::tearDown();

        unset(
            $this->client,
            $this->serializer,
            $this->articleGateway,
        );
    }

    public function testGetArticle(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getContent')
            ->with(false)
            ->willReturn('content');

        $this->client->expects(self::once())
            ->method('request')
            ->with('GET', 'en-us/slideshow-json/factory/collection/a/article')
            ->willReturn($response);

        $expectedArticle = $this->createArticle(5, 'article', 'Article', 5.5);
        $articles = Articles::fromList([
            $this->createArticle(6, 'wrong_article', 'WrongArticle', 5.5),
            $expectedArticle,
            $this->createArticle(7, 'wrong_article_2', 'WrongArticle2', 5.5),
        ]);

        $this->serializer->expects(self::once())
            ->method('deserialize')
            ->with('content', Articles::class, JsonEncoder::FORMAT)
            ->willReturn($articles);

        $article = $this->articleGateway->getArticle('factory', 'collection', 'article');

        self::assertSame($expectedArticle, $article);
    }

    public function testGetArticleWhenArticleNotFound(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getContent')
            ->with(false)
            ->willReturn('content');

        $this->client->expects(self::once())
            ->method('request')
            ->with('GET', 'en-us/slideshow-json/factory/collection/a/article')
            ->willReturn($response);

        $articles = Articles::fromList([
            $this->createArticle(6, 'wrong_article', 'WrongArticle', 5.5),
            $this->createArticle(7, 'wrong_article_2', 'WrongArticle2', 5.5),
        ]);

        $this->serializer->expects(self::once())
            ->method('deserialize')
            ->with('content', Articles::class, JsonEncoder::FORMAT)
            ->willReturn($articles);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageIs(NotFoundException::ARTICLE_NOT_FOUND_MESSAGE);

        $this->articleGateway->getArticle('factory', 'collection', 'article');
    }

    public function testGetArticleWhenResponseNotDeserializated(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getContent')
            ->with(false)
            ->willReturn('content');

        $this->client->expects(self::once())
            ->method('request')
            ->with('GET', 'en-us/slideshow-json/factory/collection/a/article')
            ->willReturn($response);

        $exception = $this->createStub(SerializerExceptionInterface::class);
        $this->serializer->expects(self::once())
            ->method('deserialize')
            ->with('content', Articles::class, JsonEncoder::FORMAT)
            ->willThrowException($exception);

        $this->expectException(DeserializationException::class);
        $this->expectExceptionMessageIs(DeserializationException::DESERIALIZATION_FAILED_MESSAGE);

        $this->articleGateway->getArticle('factory', 'collection', 'article');
    }

    public function testGetArticleWhenHttpException(): void
    {
        $exception = $this->createStub(HttpExceptionInterface::class);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getContent')
            ->with(false)
            ->willThrowException($exception);

        $this->client->expects(self::once())
            ->method('request')
            ->with('GET', 'en-us/slideshow-json/factory/collection/a/article')
            ->willReturn($response);

        $this->serializer->expects(self::never())->method('deserialize');

        $this->expectException(HttpException::class);
        $this->expectExceptionMessageIs(HttpException::UNEXPECTED_RESPONSE_MESSAGE);

        $this->articleGateway->getArticle('factory', 'collection', 'article');
    }

    private function createArticle(int $id, string $url, string $name, float $priceUSE): Article
    {
        $factory = new Factory(2, 'factory', 'Factory');
        $collection = new Collection(3, 'collection', 'Collection', $factory);

        return new Article($id, $url, $name, $priceUSE, $collection);
    }
}
