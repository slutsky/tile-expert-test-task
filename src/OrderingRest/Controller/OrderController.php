<?php

declare(strict_types=1);

namespace App\OrderingRest\Controller;

use App\Ordering\OrderNotFoundException;
use App\Ordering\OrderRepositoryInterface;
use App\OrderingRest\Dto\OrderCountFilterDto;
use App\OrderingRest\Dto\OrderDto;
use App\OrderingRest\Dto\PaginatedCountByPeriodDto;
use App\OrderingRest\Service\OrderSearcher;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'Ordering')]
final class OrderController extends AbstractController
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly OrderSearcher $orderSearcher,
    ) {
    }

    /**
     * @throws OrderNotFoundException
     */
    #[Route(methods: 'GET', path: '/api/v1/orders/{orderId}', format: 'json', requirements: [
        'orderId' => '\d+',
    ])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Get orders',
        content: new OA\JsonContent(
            ref: new Model(type: PaginatedCountByPeriodDto::class),
        ),
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Validation exception',
        content: new OA\JsonContent(ref: '#/components/schemas/ValidationExceptionResponse'),
    )]
    public function getOrder(int $orderId): JsonResponse
    {
        try {
            $order = $this->orderRepository->getById($orderId);
        } catch (OrderNotFoundException $exception) {
            throw $this->createNotFoundException($exception->getMessage(), $exception);
        }

        return $this->json(OrderDto::fromEntity($order));
    }

    #[Route(methods: 'GET', path: '/api/v1/orders/search', format: 'json')]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Search orders',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: new Model(type: OrderDto::class),
            ),
        ),
    )]
    public function searchOrders(
        #[MapQueryParameter(name: 's', validationFailedStatusCode: Response::HTTP_BAD_REQUEST)]
        string $search,
    ): JsonResponse {
        $orders = $this->orderSearcher->search($search);

        return $this->json(OrderDto::fromEntities($orders));
    }

    #[Route(methods: 'GET', path: '/api/v1/orders/count', format: 'json')]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Count orders',
        content: new OA\JsonContent(
            ref: new Model(type: PaginatedCountByPeriodDto::class),
        ),
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Validation exception',
        content: new OA\JsonContent(ref: '#/components/schemas/ValidationExceptionResponse'),
    )]
    public function countOrders(
        #[MapQueryString(validationFailedStatusCode: Response::HTTP_BAD_REQUEST)]
        OrderCountFilterDto $filter,
    ): JsonResponse {
        $count = $this->orderRepository->count();

        $elements = $this->orderRepository->countByInterval(
            $filter->intervalBy,
            $filter->limit,
            $filter->offset,
        );

        return $this->json($filter->createPaginatedCount($elements, $count));
    }
}
