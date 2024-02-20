<?php

declare(strict_types=1);

namespace App\Model;

class ErrorResponse
{
    /**
     * @param string $message
     * @param array $details
     */
    public function __construct(private readonly string $message, private readonly array $details = [])
    {
    }

    /**
     * @return array
     */
    public function getDetails(): array
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
