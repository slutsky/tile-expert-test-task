<?php

declare(strict_types=1);

namespace App\Tests\Unit\Catalog;

use App\Catalog\Article;
use App\Catalog\Collection;
use App\Catalog\Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Article::class)]
class ArticleTest extends TestCase
{
    public function testCreation(): void
    {
        $factory = new Factory(6, 'factory', 'Factory');
        $collection = new Collection(5, 'collection', 'Collection', $factory);
        $article = new Article(3, 'article', 'Article', 4.3, $collection);

        self::assertEquals($article->id, 3);
        self::assertEquals($article->url, 'article');
        self::assertEquals($article->name, 'Article');
        self::assertEquals($article->priceUSE, 4.3);
        self::assertSame($article->collection, $collection);
    }
}
