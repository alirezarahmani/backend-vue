<?php

namespace App\Domain\Services;

use App\Domain\RepositoryInterface;
use Assert\Assertion;
use Ramsey\Uuid\Uuid;

readonly class GetUserTransactionService
{
    public function __construct(
        private RepositoryInterface $transactionRepository
    )
    {
    }
    public function get(string $userId, \DateTime $date): int
    {
        $results = $this->transactionRepository->getTotalOfUserInDay(Uuid::fromString($userId), $date);
        Assertion::notNull($results[0]['id'], 'User not Found make sure you entered right id');
        return intval($results[0]['total']);
    }

}