<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

abstract class AbstractCaseTest extends TestCase
{
    /**
     * Set entity id in entities for mock entity data
     *
     * @param object $entity
     * @param int $value
     * @param string $id_field
     * @return void
     * @throws ReflectionException
     */
    protected function setEntityId(object $entity, int $value, string $id_field = 'id'): void
    {
        $reflection = new ReflectionClass($entity);
        $property = $reflection->getProperty($id_field);
        $property->setAccessible(true);
        $property->setValue($entity, $value);
        $property->setAccessible(false);
    }
}
