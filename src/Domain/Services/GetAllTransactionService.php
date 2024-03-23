<?php

namespace App\Domain\Services;

use App\Domain\Events\TransactionCachedMissedEvent;
use App\Domain\Events\TransactionSubscriber;
use App\Domain\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class GetAllTransactionService
{
    public function __construct(
        private readonly RepositoryInterface $transactionRedisRepository,
    )
    {
    }

    public function get(\DateTime $date): int
    {
        if (!$this->transactionRedisRepository->exists($date)) {
            $event = new TransactionCachedMissedEvent($date);
            $dispatcher = new EventDispatcher();
            $dispatcher->addSubscriber(new TransactionSubscriber());
            $dispatcher->dispatch($event, TransactionCachedMissedEvent::NAME);
        }
        return $this->transactionRedisRepository->getAllOfDay($date);
    }

}