<?php

declare(strict_types=1);

namespace App\Tests\Controller\Schemas;

trait BookControllerSchemas
{
    private array $testInValidBookByCategory = [
        'type' => 'object',
        'required' => ['items'],
        'properties' => [
            'items' => [
                'type' => 'array',
                'items' => [
                    'type' => 'object',
                    'required' => ['id', 'title', 'slug', 'image', 'authors', 'meap', 'date'],
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'title' => ['type' => 'string'],
                        'slug' => ['type' => 'string'],
                        'image' => ['type' => 'string'],
                        'meap' => ['type' => 'boolean'],
                        'date' => ['type' => 'integer'],
                        'authors' => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
                                'items' => [
                                    'type' => 'string'
                                ]
                            ]
                        ],
                    ]
                ]
            ]
        ]
    ];
}
