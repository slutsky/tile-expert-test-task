<?php

declare(strict_types=1);

namespace App\Tests\Application\OrderingSoap\Controller;

use App\Ordering;
use App\OrderingPersistence\Repository\OrderRepository;
use App\OrderingPersistence\Service\Flusher;
use App\OrderingPersistence\Story\SingleOrderStory;
use App\OrderingSoap\Controller\OrderController;
use App\OrderingSoap\Dto\Order;
use App\OrderingSoap\Dto\OrderBase;
use App\OrderingSoap\Dto\OrderCreate;
use App\OrderingSoap\Dto\OrderUpdate;
use App\OrderingSoap\Service\OrderService;
use App\Soap\Service as SoapService;
use App\Soap\Type as SoapType;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Attribute\WithStory;

#[CoversClass(OrderController::class)]
#[CoversClass(Order::class)]
#[CoversClass(OrderBase::class)]
#[CoversClass(OrderCreate::class)]
#[CoversClass(OrderUpdate::class)]
#[CoversClass(OrderService::class)]
#[CoversClass(OrderRepository::class)]
#[CoversClass(Flusher::class)]
#[CoversClass(Ordering\Order::class)]
#[CoversClass(Ordering\OrderService::class)]
#[CoversClass(SoapService\AutoDiscoverFactory::class)]
#[CoversClass(SoapService\ChainType::class)]
#[CoversClass(SoapService\FaultContentGenerator::class)]
#[CoversClass(SoapService\SoapServerFactory::class)]
#[CoversClass(SoapService\TypeComplexStrategy::class)]
#[CoversClass(SoapType\DateTimeImmutableType::class)]
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

    public function testGetWsdl(): void
    {
        $this->client->request(
            method: 'GET',
            uri: 'http://localhost/soap/v1/orders?wsdl',
        );

        self::assertResponseHasHeader('Content-Type', 'application/wsdl+xml; charset=utf-8');
        self::assertResponseIsSuccessful();
    }

    public function testCreateOrder(): void
    {
        $requestContent = file_get_contents(__DIR__.'/../Resources/requests/create_order_request.xml');

        self::assertNotFalse($requestContent);

        $this->client->request(
            method: 'POST',
            uri: 'http://localhost/soap/v1/orders',
            content: $requestContent,
        );

        self::assertResponseHasHeader('Content-Type', 'application/soap+xml; charset=utf-8');
        self::assertResponseIsSuccessful();
    }

    #[WithStory(SingleOrderStory::class)]
    public function testUpdateOrder(): void
    {
        $requestContent = file_get_contents(__DIR__.'/../Resources/requests/update_order_request.xml');
        self::assertNotFalse($requestContent);

        $order = SingleOrderStory::getRandom('single_order');
        self::assertInstanceOf(Ordering\Order::class, $order);

        $requestContent = str_replace('<id>1</id>', '<id>'.$order->id.'</id>', $requestContent);

        $this->client->request(
            method: 'POST',
            uri: 'http://localhost/soap/v1/orders',
            content: $requestContent,
        );

        self::assertResponseHasHeader('Content-Type', 'application/soap+xml; charset=utf-8');
        self::assertResponseIsSuccessful();
    }

    public function testRequestWithEmptyBody(): void
    {
        $this->client->request(
            method: 'POST',
            uri: 'http://localhost/soap/v1/orders',
        );

        self::assertResponseHasHeader('Content-Type', 'application/soap+xml; charset=utf-8');
        self::assertResponseStatusCodeSame(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
