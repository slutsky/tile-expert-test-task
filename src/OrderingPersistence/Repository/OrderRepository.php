<?php

declare(strict_types=1);

namespace App\OrderingPersistence\Repository;

use App\Ordering\CountByPeriod;
use App\Ordering\IntervalBy;
use App\Ordering\Order;
use App\Ordering\OrderRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Clock\DatePoint;

/**
 * @extends ServiceEntityRepository<Order>
 */
final class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @return CountByPeriod[]
     */
    public function countByInterval(IntervalBy $intervalBy, int $limit, int $offset): array
    {
        $firstDate = match ($intervalBy) {
            IntervalBy::Year => 'DATE_FORMAT(o.createDate, \'%Y-01-01\')',
            IntervalBy::Month => 'DATE_FORMAT(o.createDate, \'%Y-%m-01\')',
            default => 'DATE_FORMAT(o.createDate, \'%Y-%m-%d\')',
        };

        $lastDate = match ($intervalBy) {
            IntervalBy::Year => 'DATE_FORMAT(o.createDate, \'%Y-12-31\')',
            IntervalBy::Month => 'LAST_DAY(o.createDate)',
            default => 'DATE_FORMAT(o.createDate, \'%Y-%m-%d\')',
        };

        $groupBy = match ($intervalBy) {
            IntervalBy::Year => 'DATE_FORMAT(o.createDate, \'%Y\')',
            IntervalBy::Month => 'DATE_FORMAT(o.createDate, \'%Y-%m\')',
            default => 'DATE_FORMAT(o.createDate, \'%Y-%m-%d\')',
        };

        $queryBuilder = $this->createQueryBuilder('o')
            ->select('COUNT(o.id) ct', $firstDate.' fr', $lastDate.' to', $groupBy.' HIDDEN gp')
            ->groupBy('gp');

        /** @phpstan-var array<int, array{ct: int, fr: string, to: string}> $result */
        $result = $queryBuilder->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getResult();

        return array_map(
            static fn ($interval) => new CountByPeriod(
                DatePoint::createFromFormat('Y-m-d', $interval['fr']),
                DatePoint::createFromFormat('Y-m-d', $interval['to']),
                $interval['ct'],
            ),
            $result,
        );
    }
}
