<?php

declare(strict_types=1);

namespace App\OrderingRest\Dto;

use App\Ordering\CountByPeriod;
use App\Ordering\IntervalBy;

final class PaginatedCountByPeriodDto
{
    /**
     * @param array<int, CountByPeriod> $elements
     *
     * @phpstan-param list<CountByPeriod> $elements
     */
    public function __construct(
        public private(set) array $elements,
        public private(set) int $count,
        public private(set) IntervalBy $intervalBy,
        public private(set) int $page,
        public private(set) int $pageSize,
        public private(set) int $pageRealSize,
    ) {
    }
}
