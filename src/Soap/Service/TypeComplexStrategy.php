<?php

declare(strict_types=1);

namespace App\Soap\Service;

use Laminas\Soap\Wsdl;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\ComplexTypeStrategyInterface;

final class TypeComplexStrategy implements ComplexTypeStrategyInterface
{
    public function __construct(
        private readonly TypeInterface $type,
    ) {
    }

    public function setContext(Wsdl $context): void
    {
    }

    public function addComplexType($type)
    {
        if ($type === $this->type->getPhpType()) {
            return $this->shortNamespace($this->type->getXmlNamespace()).':'.$this->type->getXmlType();
        }

        return '';
    }

    private function shortNamespace(string $namespace): string
    {
        return match ($namespace) {
            Wsdl::XML_NS_URI => Wsdl::XML_NS,
            Wsdl::WSDL_NS_URI => Wsdl::WSDL_NS,
            Wsdl::SOAP_11_NS_URI => Wsdl::SOAP_11_NS,
            Wsdl::SOAP_12_NS_URI => Wsdl::SOAP_12_NS,
            Wsdl::SOAP_ENC_URI => Wsdl::SOAP_ENC_NS,
            Wsdl::XSD_NS_URI => Wsdl::XSD_NS,
            default => Wsdl::TYPES_NS,
        };
    }
}
