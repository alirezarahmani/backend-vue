<?php

namespace App\Domain\Entity;

use Assert\Assertion;

trait EntityAttributes
{
    private \DateTime $createdAt;
    private string $id;

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getFormattedDate(): string
    {
        return Transaction::formatDate($this->getCreatedAt());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        Assertion::uuid($id, 'only valid uuid is needed');
        $this->id = $id;
    }

    public static function formatDate(\DateTime $time): string
    {
        return $time->format('Y-m-d');
    }
}