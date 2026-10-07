<?php

declare(strict_types=1);

namespace App\Tests\Unit\Catalog;

use App\Catalog\Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Factory::class)]
class FactoryTest extends TestCase
{
    public function testCreation(): void
    {
        $factory = new Factory(6, 'factory', 'Factory');

        self::assertEquals($factory->id, 6);
        self::assertEquals($factory->url, 'factory');
        self::assertEquals($factory->name, 'Factory');
    }
}
