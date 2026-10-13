<?php

declare(strict_types=1);

namespace App\Manticore\Service;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * @template TEntity = object
 */
#[AutoconfigureTag(name: 'app.manticore.entity_mapping')]
interface EntityMappingInterface
{
    /**
     * @phpstan-return class-string<TEntity>
     */
    public function getEntity(): string;

    public function getTable(): string;

    /**
     * @return array<string, array<string, mixed>>
     *
     * @phpstan-return array<string, array{
     *     type: string,
     * }>
     */
    public function getFields(): array;

    /**
     * @return array<string, mixed>
     *
     * @phpstan-return array{
     *     charset_table: string,
     *     morphology: string,
     *     min_infix_len: string,
     * }
     */
    public function getSettings(): array;
}
