<?php

declare(strict_types=1);

namespace App\Soap\Service;

use Laminas\Soap\Wsdl\ComplexTypeStrategy\ComplexTypeStrategyInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class ChainType
{
    /**
     * @param iterable<int, TypeInterface> $types
     *
     * @phpstan-param list<TypeInterface> $types
     */
    public function __construct(
        #[AutowireIterator('app.soap.type')]
        private readonly iterable $types,
    ) {
    }

    /**
     * @phpstan-return list<array{
     *     type_ns: string,
     *     type_name: string,
     *     from_xml: callable(string): mixed,
     *     to_xml: callable(mixed): string,
     * }>
     */
    public function createTypeMap(): array
    {
        $typeMap = [];
        foreach ($this->types as $type) {
            $typeMap[] = [
                'type_ns' => $type->getXmlNamespace(),
                'type_name' => $type->getXmlType(),
                'from_xml' => [$type, 'fromXml'],
                'to_xml' => [$type, 'toXml'],
            ];
        }

        return $typeMap;
    }

    /**
     * @return array<string, ComplexTypeStrategyInterface>
     */
    public function createComplexStrategyMap(): array
    {
        $stratygyMap = [];
        foreach ($this->types as $type) {
            $stratygyMap[$type->getPhpType()] = new TypeComplexStrategy($type);
        }

        return $stratygyMap;
    }
}
