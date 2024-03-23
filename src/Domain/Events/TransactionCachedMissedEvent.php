<?php

namespace App\Domain\Events;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

final class TransactionCachedMissedEvent extends Event
{
    public const NAME = 'transaction.missed';

    public function __construct(private \DateTime $date)
    {
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }
}