<?php

declare(strict_types=1);

namespace App\CatalogIntegration\Service;

use App\Catalog\Article;
use App\Catalog\ArticleGatewayInterface;
use App\Catalog\Articles;
use App\CatalogIntegration\Exception\DeserializationException;
use App\CatalogIntegration\Exception\HttpException;
use App\CatalogIntegration\Exception\NotFoundException;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface as HttpExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ArticleGateway implements ArticleGatewayInterface
{
    public function __construct(
        #[Target('catalog')]
        private readonly HttpClientInterface $client,
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws HttpException
     * @throws DeserializationException
     * @throws NotFoundException
     */
    #[\Override]
    public function getArticle(string $factory, string $collection, string $article): Article
    {
        $url = sprintf('en-us/slideshow-json/%s/%s/a/%s', $factory, $collection, $article);
        $response = $this->client->request('GET', $url);

        $content = '';
        try {
            $content = $response->getContent(false);
        } catch (HttpExceptionInterface $exception) {
            throw HttpException::unexpectedResponse($exception);
        }

        try {
            $deserialized = $this->serializer->deserialize($content, Articles::class, JsonEncoder::FORMAT);
        } catch (SerializerExceptionInterface $exception) {
            throw DeserializationException::deserializationFailed($exception);
        }

        foreach ($deserialized->elements as $element) {
            if ($element->url === $article) {
                return $element;
            }
        }

        throw NotFoundException::articleNotFound();
    }
}
