<?php

declare(strict_types=1);

namespace App\CatalogIntegration\Exception;

use App\Catalog\ExceptionInterface;

class DeserializationException extends \RuntimeException implements ExceptionInterface
{
    public const string DESERIALIZATION_FAILED_MESSAGE = 'Deserialization failed.';

    public static function deserializationFailed(?\Throwable $previous = null): self
    {
        return new self(self::DESERIALIZATION_FAILED_MESSAGE, 0, $previous);
    }
}
