<?php

declare(strict_types=1);

namespace App\CatalogIntegration\Dto;

use OpenApi\Attributes as OA;

class ArticleFilterDto
{
    public function __construct(
        #[OA\Property(example: 'marca-corona')]
        public private(set) string $factory,
        #[OA\Property(example: 'arteseta')]
        public private(set) string $collection,
        #[OA\Property(example: 'k263-arteseta-camoscio-s000628660')]
        public private(set) string $article,
    ) {
    }
}
