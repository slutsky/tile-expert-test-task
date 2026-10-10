<?php

declare(strict_types=1);

namespace App\Soap\Service;

use Laminas\Soap\Server;

class SoapServerFactory
{
    public function __construct(
        private readonly ChainType $chainType,
    ) {
    }

    public function create(?string $wsdlPath = null): Server
    {
        $soapServer = new Server($wsdlPath);

        $soapServer
            ->setTypemap($this->chainType->createTypeMap())
            ->setReturnResponse(true);

        return $soapServer;
    }
}
