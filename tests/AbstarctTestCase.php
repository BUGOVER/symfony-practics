<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

class AbstarctTestCase extends TestCase
{
    /**
     * Set entity id in entities for mock entity data
     *
     * @param object $entity
     * @param int $value
     * @param $idField
     * @return void
     * @throws ReflectionException
     */
    protected function setEntityId(object $entity, int $value, string $idField = 'id')
    {
        $reflection = new ReflectionClass($entity);
        $property = $reflection->getProperty($idField);
        $property->setAccessible(true);
        $property->setValue($entity, $value);
        $property->setAccessible(false);
    }
}
