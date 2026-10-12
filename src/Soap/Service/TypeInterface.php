<?php

declare(strict_types=1);

namespace App\Soap\Service;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.soap.type')]
interface TypeInterface
{
    public function getXmlNamespace(): string;

    public function getPhpType(): string;

    public function getXmlType(): string;

    public function fromXml(string $xml): mixed;

    public function toXml(mixed $value): string;
}
