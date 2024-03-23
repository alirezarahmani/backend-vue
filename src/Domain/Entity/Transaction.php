<?php

namespace App\Domain\Entity;

use Money\Money;
use Ramsey\Uuid\Uuid;

class Transaction
{
    use EntityAttributes;

    public function __construct(private readonly User $user, private readonly Money $amount)
    {
        $this->id = Uuid::uuid4();
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }
}