<?php

declare(strict_types=1);

namespace App\Tests\Functional\OrderingPersistence\Repository;

use App\Ordering\CountByPeriod;
use App\Ordering\IntervalBy;
use App\Ordering\Order;
use App\Ordering\OrderArticle;
use App\Ordering\OrderNotFoundException;
use App\OrderingPersistence\Factory\OrderArticleFactory;
use App\OrderingPersistence\Factory\OrderFactory;
use App\OrderingPersistence\Repository\OrderRepository;
use App\OrderingPersistence\Story\OrderStory;
use App\OrderingPersistence\Story\SingleOrderStory;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Attribute\WithStory;

#[CoversClass(OrderRepository::class)]
#[CoversClass(OrderFactory::class)]
#[CoversClass(OrderArticleFactory::class)]
#[CoversClass(SingleOrderStory::class)]
#[CoversClass(OrderStory::class)]
#[CoversClass(Order::class)]
#[CoversClass(OrderArticle::class)]
#[CoversClass(CountByPeriod::class)]
#[WithStory(OrderStory::class)]
class OrderRepositoryTest extends KernelTestCase
{
    private OrderRepository $orderRepository;

    #[\Override]
    protected function setUp(): void
    {
        $container = self::getContainer();

        $orderRepository = $container->get(OrderRepository::class);
        self::assertInstanceOf(OrderRepository::class, $orderRepository);

        $this->orderRepository = $orderRepository;

        parent::setUp();
    }

    #[\Override]
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->orderRepository);
    }

    #[WithStory(SingleOrderStory::class)]
    public function testGetOrder(): void
    {
        $expectedOrder = SingleOrderStory::getRandom('single_order');
        self::assertInstanceOf(Order::class, $expectedOrder);

        $order = $this->orderRepository->getById($expectedOrder->id);

        self::assertSame($expectedOrder, $order);
    }

    public function testGetOrderWhenOrderNotFound(): void
    {
        $this->expectException(OrderNotFoundException::class);

        $this->orderRepository->getById(1);
    }

    public function testCountByDate(): void
    {
        $counts = $this->orderRepository->countByInterval(IntervalBy::Date, 15, 15);

        self::assertCount(5, $counts);
    }

    public function testCountByMonth(): void
    {
        $counts = $this->orderRepository->countByInterval(IntervalBy::Month, 15, 1);

        self::assertCount(2, $counts);
    }

    public function testCountByYear(): void
    {
        $counts = $this->orderRepository->countByInterval(IntervalBy::Year, 15, 1);

        self::assertCount(1, $counts);
    }
}
