<?php

declare(strict_types=1);

namespace App\Model\DTO;

class SubscriberListItem
{
    private int $id;

    private string $email;

    private int $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): SubscriberListItem
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): SubscriberListItem
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): SubscriberListItem
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
