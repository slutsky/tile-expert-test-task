<?php

declare(strict_types=1);

namespace App\Ordering;

enum IntervalBy: string
{
    case Year = 'Year';
    case Month = 'Month';
    case Date = 'Date';
}
