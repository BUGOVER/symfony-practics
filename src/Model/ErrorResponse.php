<?php

declare(strict_types=1);

namespace App\Model;

class ErrorResponse
{
    /**
     * @param string $message
     */
    public function __construct(private readonly string $message, private readonly mixed $details = null)
    {
    }

    /**
     * @return mixed
     */
    public function getDetails(): mixed
    {
        return $this->details;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
