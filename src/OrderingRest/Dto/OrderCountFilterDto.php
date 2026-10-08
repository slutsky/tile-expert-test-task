<?php

declare(strict_types=1);

namespace App\OrderingRest\Dto;

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
}
