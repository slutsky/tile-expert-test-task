<?php

declare(strict_types=1);

namespace App\OrderingPersistence\Story;

use App\OrderingPersistence\Factory\OrderArticleFactory;
use App\OrderingPersistence\Factory\OrderFactory;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

#[AsFixture(name: 'order')]
final class OrderStory extends Story
{
    public function build(): void
    {
        $groups = [
            ['createDate' => new \DateTimeImmutable('2010-10-11'), 'randomTime' => false],
            ['createDate' => new \DateTimeImmutable('2010-10-12'), 'randomTime' => false],
            ['createDate' => new \DateTimeImmutable('2010-10-13'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2010-10-14'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2010-10-15'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2010-10-16'), 'randomTime' => false],
            ['createDate' => new \DateTimeImmutable('2010-10-17'), 'randomTime' => false],
            ['createDate' => new \DateTimeImmutable('2010-10-18'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2015-11-11'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2015-11-12'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2015-11-13'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2015-11-14'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2015-11-15'), 'randomTime' => false],
            ['createDate' => new \DateTimeImmutable('2015-11-16'), 'randomTime' => false],
            ['createDate' => new \DateTimeImmutable('2015-11-17'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2015-11-18'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2015-12-11'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2015-12-12'), 'randomTime' => true],
            ['createDate' => new \DateTimeImmutable('2015-12-13'), 'randomTime' => false],
            ['createDate' => new \DateTimeImmutable('2015-12-14'), 'randomTime' => false],
        ];

        $orders = [];
        foreach ($groups as $group) {
            $created = OrderFactory::new()->withCreateDate(...$group)->many(5)->create();
            $orders = [...$orders, ...$created];
        }

        OrderArticleFactory::createMany(1000, static fn () => [
            'orderId' => $orders[rand(0, count($orders) - 1)]->id,
        ]);
    }
}
