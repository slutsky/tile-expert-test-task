<?php

declare(strict_types=1);

/**
 * This file ignore some php-cs-fixer rules because laminas/laminas-soap uses
 * the old annotation format.
 *
 * @php-cs-fixer-ignore fully_qualified_strict_types,no_superfluous_phpdoc_tags,no_empty_phpdoc
 */

namespace App\OrderingSoap\Dto;

class OrderCreate extends OrderBase
{
}
