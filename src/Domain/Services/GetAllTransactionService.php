<?php

namespace App\Domain\Services;

use App\Domain\Events\TransactionCachedMissedEvent;
use App\Domain\Events\TransactionSubscriber;
use App\Domain\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

readonly class GetAllTransactionService
{
    public function __construct(
        private RepositoryInterface $transactionRedisRepository,
    )
    {
    }

    public function get(\DateTime $date): int
    {
        $key = $this->transactionRedisRepository->getKey($date);
        if (!$this->transactionRedisRepository->exists($key)) {
            $event = new TransactionCachedMissedEvent($date);
            $dispatcher = new EventDispatcher();
            $dispatcher->addSubscriber(new TransactionSubscriber());
            $dispatcher->dispatch($event, TransactionCachedMissedEvent::NAME);
        }
        return $this->transactionRedisRepository->getAllOfDay($date);
    }

}