<?php

declare(strict_types=1);

namespace App\OrderingRest\Controller;

use App\Ordering\OrderRepositoryInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
            type: 'object',
            properties: [
                new OA\Property(property: 'count', type: 'number', example: 10),
            ],
        ),
    )]
    public function countOrders(): JsonResponse
    {
        return $this->json([
            'count' => $this->orderRepository->count(),
        ]);
    }
}
