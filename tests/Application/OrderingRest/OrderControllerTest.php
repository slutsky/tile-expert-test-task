<?php

declare(strict_types=1);

namespace App\Tests\Application\OrderingRest;

use App\Ordering\Order;
use App\OrderingPersistence\Factory\OrderFactory;
use App\OrderingPersistence\Repository\OrderRepository;
use App\OrderingPersistence\Story\OrderStory;
use App\OrderingRest\Controller\OrderController;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Attribute\WithStory;

#[CoversClass(OrderController::class)]
#[CoversClass(OrderRepository::class)]
#[CoversClass(OrderFactory::class)]
#[CoversClass(OrderStory::class)]
#[CoversClass(Order::class)]
class OrderControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    #[\Override]
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->client);
    }

    #[WithStory(OrderStory::class)]
    public function testCount(): void
    {
        $this->client->jsonRequest('GET', '/api/v1/orders/count');

        self::assertResponseIsSuccessful();
    }
}
