<?php

declare(strict_types=1);

namespace App\CatalogIntegration\Dto;

class ArticleFilterDto
{
    public function __construct(
        public private(set) string $factory,
        public private(set) string $collection,
        public private(set) string $article,
    ) {
    }
}
