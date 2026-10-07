<?php

declare(strict_types=1);

namespace App\Catalog;

final class Articles
{
    /**
     * @param Article[] $elements
     *
     * @phpstan-param array<numeric-string, Article> $elements
     */
    public function __construct(
        public private(set) array $elements,
    ) {
    }

    /**
     * @param Article[] $articles
     *
     * @phpstan-param list<Article> $articles
     */
    public static function fromList(array $articles): self
    {
        $elements = [];
        foreach ($articles as $article) {
            $elements[(string) $article->id] = $article;
        }

        return new self($elements);
    }
}
