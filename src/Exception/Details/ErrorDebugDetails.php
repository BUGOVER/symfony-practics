<?php

declare(strict_types=1);

namespace App\Exception\Details;

class ErrorDebugDetails
{
    /**
     * @param string $trace
     */
    public function __construct(private string $trace)
    {
    }

    public function getTrace(): string
    {
        return $this->trace;
    }
}
