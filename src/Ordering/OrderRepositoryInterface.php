<?php

declare(strict_types=1);

namespace App\Ordering;

interface OrderRepositoryInterface
{
    public function count(): int;
}
