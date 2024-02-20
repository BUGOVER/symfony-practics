<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends RuntimeException
{
    public function __construct(private ConstraintViolationListInterface $constraintViolationList)
    {
        parent::__construct('validation failed');
    }

    public function getViolarion()
    {
        return $this->constraintViolationList;
    }
}
