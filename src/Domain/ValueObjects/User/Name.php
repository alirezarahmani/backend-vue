<?php

namespace App\Domain\ValueObjects\User;

use App\Domain\ValueObjects\ValueObjectInterface;
use Assert\Assertion;
use Assert\AssertionFailedException;

readonly class Name implements ValueObjectInterface
{
    /**
     * @throws AssertionFailedException
     */
    public function __construct(private string $name)
    {
        Assertion::notEmpty('name must not be empty');
    }

    public function isEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}