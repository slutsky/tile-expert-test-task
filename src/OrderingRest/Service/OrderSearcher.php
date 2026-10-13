<?php

declare(strict_types=1);

namespace App\OrderingRest\Service;

use App\Manticore\Service\ManticoreSearcherInterface;
use App\Ordering\Order;

class OrderSearcher
{
    public function __construct(
        private readonly ManticoreSearcherInterface $searcher,
    ) {
    }

    /**
     * @return array<int, Order>
     */
    public function search(string $search): array
    {
        return $this->searcher->search(Order::class, $search);
    }
}
