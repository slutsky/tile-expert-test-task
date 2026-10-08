<?php

declare(strict_types=1);

namespace App\OrderingRest\Controller;

use App\Ordering\OrderRepositoryInterface;
use App\OrderingRest\Dto\OrderCountFilterDto;
use App\OrderingRest\Dto\PaginatedCountByPeriodDto;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'Ordering')]
final class OrderController extends AbstractController
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
    ) {
    }

    #[Route(methods: 'GET', path: '/api/v1/orders/count', format: 'json')]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'count orders',
        content: new OA\JsonContent(
            ref: new Model(type: PaginatedCountByPeriodDto::class),
        ),
    )]
    public function countOrders(
        #[MapQueryString]
        OrderCountFilterDto $filter,
    ): JsonResponse {
        $elements = $this->orderRepository->countByInterval(
            $filter->intervalBy,
            $filter->limit,
            $filter->offset,
        );

        return $this->json(new PaginatedCountByPeriodDto(
            $elements,
            $filter->page,
        ));
    }
}
