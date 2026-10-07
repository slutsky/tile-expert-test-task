<?php

declare(strict_types=1);

namespace App\Catalog;

interface ArticleGatewayInterface
{
    public function getArticle(string $factory, string $collection, string $article): Article;
}
