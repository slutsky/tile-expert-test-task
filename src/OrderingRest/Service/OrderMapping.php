<?php

declare(strict_types=1);

namespace App\OrderingRest\Service;

use App\Manticore\Service\EntityMappingInterface;
use App\Ordering\Order;

/**
 * @implements EntityMappingInterface<Order>
 */
class OrderMapping implements EntityMappingInterface
{
    public function getEntity(): string
    {
        return Order::class;
    }

    public function getTable(): string
    {
        return 'orders';
    }

    public function getFields(): array
    {
        return [
            'name' => ['type' => 'text'],
            'description' => ['type' => 'text'],
        ];
    }

    public function getSettings(): array
    {
        return [
            'charset_table' => 'non_cjk',
            'morphology' => 'lemmatize_ru, lemmatize_en',
            'min_infix_len' => '3',
        ];
    }
}
