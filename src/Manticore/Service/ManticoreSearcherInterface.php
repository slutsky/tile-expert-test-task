<?php

declare(strict_types=1);

namespace App\Manticore\Service;

interface ManticoreSearcherInterface
{
    /**
     * @template TEntity of object = object
     *
     * @phpstan-param class-string<TEntity> $entityClass
     *
     * @phpstan-return TEntity[]
     */
    public function search(string $entityClass, string $search): array;
}
