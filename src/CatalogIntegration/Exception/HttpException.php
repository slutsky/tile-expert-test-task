<?php

declare(strict_types=1);

namespace App\CatalogIntegration\Exception;

use App\Catalog\ExceptionInterface;

class HttpException extends \RuntimeException implements ExceptionInterface
{
    public const UNEXPECTED_RESPONSE_MESSAGE = 'Unexpected response.';

    public static function unexpectedResponse(?\Throwable $previous = null): self
    {
        return new self(self::UNEXPECTED_RESPONSE_MESSAGE, 0, $previous);
    }
}
