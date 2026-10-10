<?php

declare(strict_types=1);

namespace App\OrderingPersistence\Service;

use App\Ordering\FlusherInterface;
use Doctrine\ORM\EntityManagerInterface;

final class Flusher implements FlusherInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
