<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Throwable;

class RequestBodyConvertException extends RuntimeException
{
    /**
     * @param Throwable $throwable
     */
    public function __construct(Throwable $throwable)
    {
        parent::__construct($throwable->getMessage() ?? 'error on convert request body');
    }
}
