<?php

declare(strict_types=1);

namespace App\Tests\Unit\Catalog;

use App\Catalog\Article;
use App\Catalog\Articles;
use App\Catalog\Collection;
use App\Catalog\Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Articles::class)]
class ArticlesTest extends TestCase
{
    private Collection $collection;

    #[\Override]
    protected function setUp(): void
    {
        $factory = new Factory(6, 'factory', 'Factory');
        $this->collection = new Collection(5, 'collection', 'Collection', $factory);

        parent::setUp();
    }

    #[\Override]
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->collection);
    }

    public function testCreation(): void
    {
        $elements = $this->createElements();

        $articles = new Articles($elements);

        self::assertEquals($elements, $articles->elements);
    }

    public function testFromList(): void
    {
        $elementList = array_values($this->createElements());

        $articles = Articles::fromList($elementList);

        $keys = array_keys($articles->elements);

        self::assertEquals(['3', '1', '2'], $keys);
    }

    /**
     * @return Article[]
     *
     * @phpstan-return array<numeric-string, Article>
     */
    public function createElements(): array
    {
        return [
            '3' => $this->createArticle(3, 'url1', 'name1', 4.3),
            '1' => $this->createArticle(1, 'url2', 'name2', 4.1),
            '2' => $this->createArticle(2, 'url3', 'name3', 4.2),
        ];
    }

    private function createArticle(int $id, string $url, string $name, float $priceUSE): Article
    {
        return new Article($id, $url, $name, $priceUSE, $this->collection);
    }
}
