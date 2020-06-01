<?php

declare(strict_types=1);

namespace Arbify\Arb\Importer;

use Exception;
use Throwable;

class ImportException extends Exception
{
    protected ?string $solution;

    public function __construct(string $message = '', ?string $solution = null, Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);

        $this->solution = $solution;
    }

    public function getSolution(): ?string
    {
        return $this->solution;
    }
}
