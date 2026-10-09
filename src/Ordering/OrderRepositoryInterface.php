<?php

declare(strict_types=1);

namespace App\Ordering;

interface OrderRepositoryInterface
{
    public function count(): int;

    /**
     * @return array<int, CountByPeriod>
     *
     * @phpstan-return list<CountByPeriod>
     */
    public function countByInterval(IntervalBy $intervalBy, int $limit, int $offset): array;
}
