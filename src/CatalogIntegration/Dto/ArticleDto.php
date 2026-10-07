<?php

declare(strict_types=1);

namespace App\CatalogIntegration\Dto;

class ArticleDto
{
    public function __construct(
        public private(set) float $price,
        public private(set) string $factory,
        public private(set) string $collection,
        public private(set) string $article,
    ) {
    }
}
