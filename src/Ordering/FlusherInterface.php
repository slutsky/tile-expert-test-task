<?php

declare(strict_types=1);

namespace App\Ordering;

interface FlusherInterface
{
    public function flush(): void;
}
