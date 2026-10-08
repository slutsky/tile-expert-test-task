<?php

declare(strict_types=1);

namespace App\OrderingPersistence\Story;

use App\OrderingPersistence\Factory\OrderFactory;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

#[AsFixture(name: 'order')]
final class OrderStory extends Story
{
    public function build(): void
    {
        OrderFactory::createMany(100);
    }
}
