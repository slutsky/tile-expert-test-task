<?php

declare(strict_types=1);

namespace App\Manticore\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Manticoresearch\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Contracts\Service\ResetInterface;

final class ManticoreService implements ManticoreSearcherInterface, ResetInterface
{
    private const string TABLE_ALIAS = 'entity';
    private const int BATCH_SIZE = 100;

    /**
     * @var array<string, EntityMappingInterface>
     *
     * @phpstan-var array<class-string, EntityMappingInterface>
     */
    private array $entityMap;

    /**
     * @param iterable<int, EntityMappingInterface> $entityMappings
     *
     * @phpstan-param list<EntityMappingInterface> $entityMappings
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EntityManagerInterface $entityManager,
        private readonly Client $client,
        #[AutowireIterator('app.manticore.entity_mapping')]
        private readonly iterable $entityMappings,
    ) {
    }

    #[\Override]
    public function reset()
    {
        unset($this->entityMap);
    }

    public function deleteTables(): void
    {
        $this->logger->info('Start to delete manticore tables.');

        /** @phpstan-var list<array{Table: string, Type: string}> $tableList */
        $tableList = $this->client->sql('SHOW TABLES;', true);
        foreach ($tableList as ['Table' => $tableName]) {
            $this->client->table($tableName)->drop();
        }

        $this->logger->info('Manticore tables deleted.');
    }

    public function createTables(): void
    {
        $this->logger->info('Start to create manticore tables.');

        foreach ($this->entityMappings as $entityMapping) {
            $entityMetadata = $this->entityManager->getClassMetadata(
                $entityMapping->getEntity(),
            );

            // TODO: Implement complex key
            [$idName] = $entityMetadata->getIdentifier();

            $idType = $entityMetadata->getTypeOfField($idName);

            // TODO: Implement another types
            if ('integer' !== $idType && 'string' !== $idType) {
                throw new \LogicException('Current integration with Manticore implements only "int" and "string" identifiers.');
            }

            $table = $this->client->table(
                $entityMapping->getTable(),
            );

            $fields = [
                ...$entityMapping->getFields(),
                'id' => ['type' => $idType],
            ];

            $table->create($fields, $entityMapping->getSettings());
        }

        $this->logger->info('Manticore tables created.');
    }

    public function populate(): void
    {
        $this->logger->info('Start to populate manticore tables.');

        foreach ($this->entityMappings as $entityMapping) {
            $repository = $this->entityManager->getRepository(
                $entityMapping->getEntity(),
            );

            $entityMetadata = $this->entityManager->getClassMetadata(
                $entityMapping->getEntity(),
            );

            // TODO: Implement complex key
            [$idName] = $entityMetadata->getIdentifier();

            $fieldNames = [
                ...array_keys($entityMapping->getFields()),
                $idName,
            ];

            $entities = $repository->createQueryBuilder(self::TABLE_ALIAS)
                ->select(array_map(
                    static fn (string $name): string => self::TABLE_ALIAS.'.'.$name,
                    $fieldNames,
                ))
                ->getQuery()
                ->toIterable(hydrationMode: Query::HYDRATE_SCALAR);

            $table = $this->client->table(
                $entityMapping->getTable(),
            );

            $documents = [];
            $i = 0;
            foreach ($entities as $entity) {
                $documents[] = $entity;

                ++$i;
                if (($i % self::BATCH_SIZE) === 0) {
                    $table->addDocuments($documents);
                }
            }
        }

        $this->logger->info('Start to populate manticore populate.');
    }

    public function search(string $entityClass, string $search): array
    {
        $entityMap = $this->getEntityMap();
        if (!isset($entityMap[$entityClass])) {
            return [];
        }

        $entityMapping = $entityMap[$entityClass];

        $table = $this->client->table(
            $entityMapping->getTable(),
        );

        $searchResult = $table->search($search)->get();

        $ids = [];
        foreach ($searchResult as $item) {
            $ids[] = $item->getId();
        }

        $repository = $this->entityManager->getRepository($entityClass);

        return $repository->findBy(['id' => $ids]);
    }

    /**
     * @return array<string, EntityMappingInterface>
     *
     * @phpstan-return array<class-string, EntityMappingInterface>
     */
    private function getEntityMap(): array
    {
        if (!isset($this->entityMap)) {
            $this->entityMap = [];
            foreach ($this->entityMappings as $entityMapping) {
                $this->entityMap[$entityMapping->getEntity()] = $entityMapping;
            }
        }

        return $this->entityMap;
    }
}
