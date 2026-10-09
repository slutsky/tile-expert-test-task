<?php

declare(strict_types=1);

namespace App\Tests\Application\OrderingRest;

use App\Ordering\IntervalBy;
use App\OrderingPersistence\Story\OrderStory;
use App\OrderingRest\Controller\OrderController;
use App\OrderingRest\Dto\OrderCountFilterDto;
use App\OrderingRest\Dto\PaginatedCountByPeriodDto;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Attribute\WithStory;

#[CoversClass(OrderController::class)]
#[CoversClass(OrderCountFilterDto::class)]
#[CoversClass(PaginatedCountByPeriodDto::class)]
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
        $this->client->jsonRequest('GET', '/api/v1/orders/count?'.http_build_query([
            'page' => 1,
            'pageSize' => 2,
            'intervalBy' => IntervalBy::Month->value,
        ]));

        self::assertResponseIsSuccessful();
    }

    public function testCountValidationProblem(): void
    {
        $this->client->jsonRequest('GET', '/api/v1/orders/count?'.http_build_query([
            'page' => 'Wrong value',
            'pageSize' => 'Wrong value',
            'intervalBy' => 'Wrong value',
        ]));

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}
