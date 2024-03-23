<?php

namespace App\Domain\Events;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

final class TransactionAddedEvent extends Event
{
    public const NAME = 'transaction.added';

    public function __construct(private Transaction $transaction)
    {
    }

    /**
     * @return Transaction
     */
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }
}