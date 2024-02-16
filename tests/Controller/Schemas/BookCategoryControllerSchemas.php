<?php

declare(strict_types=1);

namespace App\Tests\Controller\Schemas;

trait BookCategoryControllerSchemas
{
    private array $testCategoriesSchema = [
        'type' => 'object',
        'required' => ['items'],
        'properties' => [
            'items' => [
                'type' => 'array',
                'items' => [
                    'type' => 'object',
                    'required' => ['id', 'title', 'slug'],
                    'properties' => [
                        'title' => ['type' => 'string'],
                        'slug' => ['type' => 'string'],
                        'id' => ['type' => 'integer'],
                    ]
                ]
            ]
        ]
    ];
}
