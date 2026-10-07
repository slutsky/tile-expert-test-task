<?php

declare(strict_types=1);

namespace App\CatalogIntegration\Exception;

use App\Catalog\ExceptionInterface;

class NotFoundException extends \RuntimeException implements ExceptionInterface
{
    public const ARTICLE_NOT_FOUND_MESSAGE = 'Article not found.';

    public static function articleNotFound(): self
    {
        return new self(self::ARTICLE_NOT_FOUND_MESSAGE);
    }
}
