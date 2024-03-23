<?php

namespace App\Domain\Entity;

use App\Domain\ValueObjects\User\Name;
use Money\Money;
use Ramsey\Uuid\Uuid;

class User
{
    use EntityAttributes;

    private Money $credit;

    public function __construct(private Name $name)
    {
        $this->id = Uuid::uuid4();
        $this->credit = Money::EUR(0);
        $this->setCreatedAt(new \DateTime());
    }

    public static function mapUser(string $id, string $name, int $credit)
    {
        $user = new self(new Name($name));
        $user->setId($id);
        $user->setCredit(Money::EUR($credit));
        return $user;
    }

    /**
     * @return Money
     */
    public function getCredit(): Money
    {
        return $this->credit;
    }

    private function setCredit(Money $credit)
    {
        $this->credit = $credit;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }
}