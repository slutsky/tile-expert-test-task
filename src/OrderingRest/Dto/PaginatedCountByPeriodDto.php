<?php

declare(strict_types=1);

namespace App\OrderingRest\Dto;

use App\Ordering\CountByPeriod;

final class PaginatedCountByPeriodDto
{
    public private(set) int $count;

    /**
     * @param array<int, CountByPeriod> $elements
     */
    public function __construct(
        public private(set) array $elements,
        public private(set) int $page,
    ) {
        $this->count = count($elements);
    }
}
