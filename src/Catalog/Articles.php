<?php

declare(strict_types=1);

namespace App\Catalog;

final class Articles
{
    /**
     * @param Article[] $elements
     *
     * @phpstan-param array<string, Article> $elements
     */
    public function __construct(
        public private(set) array $elements,
    ) {
    }
}
