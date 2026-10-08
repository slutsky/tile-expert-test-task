<?php

declare(strict_types=1);

namespace App\Ordering;

interface OrderRepositoryInterface
{
    /**
     * @return CountByPeriod[]
     */
    public function countByInterval(IntervalBy $intervalBy, int $limit, int $offset): array;
}
