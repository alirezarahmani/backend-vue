<?php

namespace App\Infrastructure\Services;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\User;
use App\Domain\RepositoryInterface;
use App\Domain\ValueObjects\User\Name;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Faker\Factory;
use Money\Money;

final readonly class FakerService
{
    public function __construct(
        private RepositoryInterface $userRepository,
        private RepositoryInterface $transactionRepository
    )
    {
    }

    /**
     * @throws AssertionFailedException
     */
    public function populate(int $number): void
    {
        Assertion::between($number, 1, 100, 'you can not add less than 1 or more than 100');
        // if we have more than one faker inject it
        // At start user amount is 0 then add transactions to increase amount
        $faker = Factory::create();
        for ($i = 0; $i < $number; $i++) {
            $user = new User(new Name($faker->unique()->name));
            $this->userRepository->addUser($user);
            $transaction = new Transaction($user, Money::EUR($faker->randomNumber(4)));
            $this->transactionRepository->add($transaction);
        }
    }

}