<?php

declare(strict_types=1);

namespace App\OrderingSoap\Controller;

use App\OrderingSoap\Service\OrderService;
use App\Soap\Service\AutoDiscoverFactory;
use App\Soap\Service\FaultContentGenerator;
use App\Soap\Service\SoapServerFactory;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'Ordering SOAP')]
final class OrderController extends AbstractController
{
    private const string WSDL_PATH = __DIR__.'/../../../var/order.wsdl';

    public function __construct(
        private readonly AutoDiscoverFactory $autoDiscoverFactory,
        private readonly SoapServerFactory $soapServerFactory,
        private readonly FaultContentGenerator $faultContentGenerator,
        private readonly OrderService $ordering,
    ) {
    }

    #[Route(path: '/soap/v1/orders', name: 'soap_orders')]
    public function action(Request $request): Response
    {
        $wsdl = $this->autoDiscoverFactory->create()
            ->setClass(OrderService::class)
            ->setUri($this->generateUrl('soap_orders'))
            ->setServiceName('Ordering')
            ->generate();

        if ($request->query->has('wsdl')) {
            return new Response($wsdl->toXML(), Response::HTTP_OK, [
                'Content-Type' => 'application/wsdl+xml; charset=utf-8',
            ]);
        }

        // @phpstan-ignore-next-line Error in laminas/laminas-soap annotations
        $wsdl->dump(self::WSDL_PATH);

        $soapServer = $this->soapServerFactory->create(self::WSDL_PATH)
            ->setClassmap([
                'Order' => \App\OrderingSoap\Dto\Order::class,
                'OrderCreate' => \App\OrderingSoap\Dto\OrderCreate::class,
                'OrderUpdate' => \App\OrderingSoap\Dto\OrderUpdate::class,
            ])
            ->setClass(OrderService::class)
            ->setObject($this->ordering);

        $statusCode = Response::HTTP_OK;
        $requestContent = $request->getContent();
        if ('' === $requestContent) {
            $content = new \SoapFault('Server', 'Request body must be not empty.');
        } else {
            /** @var \SoapFault|string $content Error in laminas/laminas-soap annotations */
            $content = $soapServer->handle($requestContent);
        }

        if ($content instanceof \SoapFault) {
            $content = $this->faultContentGenerator->generate($content);
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new Response($content, $statusCode, [
            'Content-Type' => 'application/soap+xml; charset=utf-8',
        ]);
    }
}
