<?php

declare(strict_types=1);

namespace App\OrderingRest\Dto;

use App\Ordering\CountByPeriod;
use App\Ordering\IntervalBy;
use Symfony\Component\Serializer\Attribute\Ignore;

final class OrderCountFilterDto
{
    #[Ignore]
    public int $limit {
        get => $this->pageSize;
    }

    #[Ignore]
    public int $offset {
        get => $this->page < 1 ? 0 : ($this->page - 1) * $this->pageSize;
    }

    public function __construct(
        public private(set) int $page = 1,
        public private(set) int $pageSize = 10,
        public private(set) IntervalBy $intervalBy = IntervalBy::Date,
    ) {
    }

    /**
     * @param array<int, CountByPeriod> $elements
     *
     * @phpstan-param list<CountByPeriod> $elements
     */
    public function createPaginatedCount(array $elements, int $count): PaginatedCountByPeriodDto
    {
        return new PaginatedCountByPeriodDto(
            $elements,
            $count,
            $this->intervalBy,
            $this->page,
            $this->pageSize,
            count($elements),
        );
    }
}
