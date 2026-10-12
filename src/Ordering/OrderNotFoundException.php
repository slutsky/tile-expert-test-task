<?php

declare(strict_types=1);

namespace App\Ordering;

class OrderNotFoundException extends \RuntimeException
{
    public const string ORDER_NOT_FOUND_MESSAGE = 'Order not found.';

    public static function create(): self
    {
        return new self(self::ORDER_NOT_FOUND_MESSAGE);
    }
}
