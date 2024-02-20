<?php

declare(strict_types=1);

namespace App\Exception\Details;

use App\Model\DTO\ErrorValidationDetailsItem;

class ErrorValidationDetails
{
    /**
     * @var ErrorValidationDetailsItem[]
     */
    private array $violations = [];

    public function __construct()
    {
        // @TODO
    }

    public function addViolation(string $field, string $message)
    {
        $this->violations[] = new ErrorValidationDetailsItem($field, $message);
    }

    /**
     * @return ErrorValidationDetailsItem[]
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
