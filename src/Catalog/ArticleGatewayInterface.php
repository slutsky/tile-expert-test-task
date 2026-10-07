<?php

declare(strict_types=1);

namespace App\Catalog;

interface ArticleGatewayInterface
{
    /**
     * @throws ExceptionInterface
     */
    public function getArticle(string $factory, string $collection, string $article): Article;
}
