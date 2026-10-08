<?php

declare(strict_types=1);

namespace App\Ordering;

class CountByPeriod
{
    public function __construct(
        public private(set) \DateTimeImmutable $from,
        public private(set) \DateTimeImmutable $to,
        public private(set) int $count,
    ) {
    }
}
