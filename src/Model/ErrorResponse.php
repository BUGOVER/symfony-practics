<?php

declare(strict_types=1);

namespace App\Model;

class ErrorResponse
{
    /**
     * @param string $message
     */
    public function __construct(private readonly string $message)
    {
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
