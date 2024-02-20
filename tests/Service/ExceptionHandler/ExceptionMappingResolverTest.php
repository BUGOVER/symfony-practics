<?php

declare(strict_types=1);

namespace App\Tests\Service\ExceptionHandler;

use App\Service\ExceptionHandler\ExceptionMappingResolver;
use App\Tests\AbstractCaseTest;
use InvalidArgumentException;

class ExceptionMappingResolverTest extends AbstractCaseTest
{
    /**
     * @return void
     */
    public function testResolveException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ExceptionMappingResolver(['someClass' => ['hidden' => true]]);
    }

    /**
     * @return void
     */
    public function testResolveExceptionNullNotFound(): void
    {
        $resolver = new ExceptionMappingResolver([]);

        self::assertNull($resolver->resolve(InvalidArgumentException::class));
    }

    public function testResolbveClassItsElf()
    {
        $resolver = new ExceptionMappingResolver([InvalidArgumentException::class => ['code' => 400]]);
        $mapping = $resolver->resolve(InvalidArgumentException::class);

        self::assertEquals(400, $mapping->getCode());
    }

    public function testResolbveClassItsInstaneException()
    {
        $resolver = new ExceptionMappingResolver([InvalidArgumentException::class => ['code' => 500]]);
        $mapping = $resolver->resolve(InvalidArgumentException::class);

        self::assertEquals(500, $mapping->getCode());
    }
}
