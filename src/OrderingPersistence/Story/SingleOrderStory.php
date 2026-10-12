<?php

declare(strict_types=1);

namespace App\OrderingPersistence\Story;

use App\OrderingPersistence\Factory\OrderFactory;
use Zenstruck\Foundry\Story;

final class SingleOrderStory extends Story
{
    public function build(): void
    {
        $this->addToPool('single_order', OrderFactory::createOne());
    }
}
