<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\Details\ErrorDebugDetails;
use App\Exception\Details\ErrorValidationDetails;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

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
        Property(type: 'object', nullable: true, oneOf: [
            new Schema(ref: new Model(type: ErrorDebugDetails::class)),
            new Schema(ref: new Model(type: ErrorValidationDetails::class)),
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
