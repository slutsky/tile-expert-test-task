<?php

declare(strict_types=1);

namespace App\Soap\Service;

use Laminas\Soap\AutoDiscover;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\Composite;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\DefaultComplexType;

class AutoDiscoverFactory
{
    public function __construct(
        private readonly ChainType $chainType,
    ) {
    }

    public function create(): AutoDiscover
    {
        return new AutoDiscover(new Composite(
            $this->chainType->createComplexStrategyMap(),
            new DefaultComplexType(),
        ));
    }
}
