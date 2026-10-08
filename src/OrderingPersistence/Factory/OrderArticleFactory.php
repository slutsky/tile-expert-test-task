<?php

declare(strict_types=1);

namespace App\OrderingPersistence\Factory;

use App\Ordering\Order;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Order>
 */
final class OrderArticleFactory extends PersistentObjectFactory
{
    public static function class(): string
    {
        return Order::class;
    }

    protected function defaults(): array|callable
    {
        $now = \DateTimeImmutable::createFromMutable(self::faker()->dateTimeThisCentury());

        $deliveryTimeMin = $now->add(\DateInterval::createFromDateString('+1 days'));
        $deliveryTimeMax = $now->add(\DateInterval::createFromDateString(
            sprintf('+%d days', self::faker()->numberBetween(2, 7)),
        ));

        return [
            'articleId' => self::faker()->numberBetween(1000, 100000),
            'amount' => self::faker()->numberBetween(1, 100),
            'price' => self::faker()->randomFloat(2, 10, 100),
            'priceEur' => self::faker()->randomFloat(2, 10, 100),
            'currency' => self::faker()->randomElement(['EUR', 'USD']),
            'measure' => 'm',
            'deliveryTimeMin' => $deliveryTimeMin,
            'deliveryTimeMax' => $deliveryTimeMax,
            'weight' => self::faker()->randomFloat(2, 10, 100),
            'multiplePallet' => self::faker()->numberBetween(1, 3),
            'packagingCount' => self::faker()->numberBetween(1, 10),
            'pallet' => self::faker()->numberBetween(1, 10),
            'packaging' => self::faker()->numberBetween(1, 10),
            'swimmingPool' => self::faker()->randomElement([true, false]),
        ];
    }
}
