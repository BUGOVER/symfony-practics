<?php

declare(strict_types=1);

namespace App\Model\Details;

class ErrorDebugDetails
{
    /**
     * @param string $trace
     */
    public function __construct(private readonly string $trace)
    {
    }

    public function getTrace(): string
    {
        return $this->trace;
    }
}
