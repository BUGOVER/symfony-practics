<?php

declare(strict_types=1);

namespace App\Model;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes\Property;

class ErrorResponse
{
    /**
     * @param string $message
     * @param ErrorDebugDetails $details
     */
    public function __construct(private readonly string $message, private readonly ErrorDebugDetails $details)
    {
    }

    #[
        Property(type: 'object', oneOf: [
            new Model(type: ErrorDebugDetails::class),
            new Model(type: ErrorValidationDetails::class),
        ])
    ]
    public function getDetails(): ErrorDebugDetails
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
