<?php

declare(strict_types=1);

namespace App\Catalog;

final class Collection
{
    public function __construct(
        public private(set) int $id,
        public private(set) string $url,
        public private(set) string $name,
        public private(set) Factory $factory,
    ) {
    }
}
