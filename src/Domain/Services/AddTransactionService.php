<?php

namespace App\Domain\Services;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\User;
use App\Domain\RepositoryInterface;
use App\Domain\ValueObjects\User\Name;
use Assert\Assertion;
use Money\Money;
use Ramsey\Uuid\Uuid;

readonly class AddTransactionService
{
    public function __construct(private RepositoryInterface $userRepository, private RepositoryInterface $transactionRepository)
    {
    }

    public function add(string $userId, int $amount): void
    {
        Assertion::uuid($userId, 'wrong uuid: ' . $userId);
        Assertion::notEq(0, $amount, 'you can not add 0 amount');
        $results = $this->userRepository->findById(Uuid::fromString($userId));
        Assertion::notEmpty($results, 'wrong id is inserted');
        $result = $results[0];
        $user = User::mapUser($result['id'], $result['name'], $result['credit']);
        $transaction = new Transaction($user, Money::EUR($amount));
        $this->transactionRepository->add($transaction);
    }
}