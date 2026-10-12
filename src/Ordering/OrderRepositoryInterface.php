<?php

declare(strict_types=1);

namespace App\Ordering;

interface OrderRepositoryInterface
{
    /**
     * @throws OrderNotFoundException
     */
    public function getById(int $order): Order;

    public function count(): int;

    /**
     * @return array<int, CountByPeriod>
     *
     * @phpstan-return list<CountByPeriod>
     */
    public function countByInterval(IntervalBy $intervalBy, int $limit, int $offset): array;

    public function add(Order $order): void;
}
