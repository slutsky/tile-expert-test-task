<?php

declare(strict_types=1);

namespace App\OrderingRest\Dto;

use App\Ordering\CountByPeriod;
use App\Ordering\IntervalBy;

final readonly class PaginatedCountByPeriodDto
{
    /**
     * @param array<int, CountByPeriod> $elements
     *
     * @phpstan-param list<CountByPeriod> $elements
     */
    public function __construct(
        public array $elements,
        public int $count,
        public IntervalBy $intervalBy,
        public int $page,
        public int $pageSize,
        public int $pageRealSize,
    ) {
    }
}
