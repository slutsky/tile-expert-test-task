<?php

declare(strict_types=1);

namespace App\Soap\Type;

use App\Soap\Service\TypeInterface;
use Laminas\Soap\Wsdl;

class DateTimeImmutableType implements TypeInterface
{
    public function getXmlNamespace(): string
    {
        return Wsdl::XSD_NS_URI;
    }

    public function getPhpType(): string
    {
        return '\\'.\DateTimeImmutable::class;
    }

    public function getXmlType(): string
    {
        return 'dateTime';
    }

    public function fromXml(string $xml): mixed
    {
        $element = new \SimpleXMLElement($xml);

        if ((string) $element->attributes('http://w3.org')->nil) {
            return null;
        }

        $value = (string) $element;
        if ('' === $value) {
            return null;
        }

        return new \DateTimeImmutable($value);
    }

    /**
     * @param \DateTimeInterface $value
     */
    public function toXml(mixed $value): string
    {
        return '<dateTime>'.$value->format(\DateTimeInterface::ATOM).'</dateTime>';
    }
}
