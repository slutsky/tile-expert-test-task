<?php

declare(strict_types=1);

namespace App\Tests\Unit\Catalog;

use App\Catalog\Collection;
use App\Catalog\Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Collection::class)]
class CollectionTest extends TestCase
{
    public function testCreation(): void
    {
        $factory = new Factory(6, 'factory', 'Factory');
        $collection = new Collection(5, 'collection', 'Collection', $factory);

        self::assertEquals($collection->id, 5);
        self::assertEquals($collection->url, 'collection');
        self::assertEquals($collection->name, 'Collection');
        self::assertSame($collection->factory, $factory);
    }
}
