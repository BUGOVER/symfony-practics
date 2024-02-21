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

    /**
     * @param string $field
     * @param string $message
     * @return void
     */
    public function addViolation(string $field, string $message): void
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
