<?php

namespace App\Domain\Events;

use App\Domain\Entity\Transaction;
use App\Infrastructure\Repositories\MeekroDB\UserRepository;
use App\Infrastructure\Repositories\MeekroDB\TransactionRepository as TransactionDBRepository;
use App\Infrastructure\Repositories\Redis\TransactionRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TransactionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            TransactionAddedEvent::NAME => 'onTransactionAdded',
            TransactionCachedMissedEvent::NAME => 'onTransactionMissed',
        ];
    }

    public function onTransactionAdded(TransactionAddedEvent $event): void
    {
        $transaction = $event->getTransaction();
        $redisRepository = new TransactionRepository();
        $this->updateUser($transaction);
        $redisRepository->addTransaction($transaction);
    }

    public function onTransactionMissed(TransactionCachedMissedEvent $event): void
    {
        $date = $event->getDate();
        $repository = new TransactionDBRepository();
        $redisRepository = new TransactionRepository();
        $results = $repository->getTotalInDay($date);
        $total = 0;
        if (empty($results[0]['total'])) {
            $redisRepository->updateTotalDay($date, $total);
        } else {
            $redisRepository->updateTotalDay($date, intval($results[0]['total']));
        }
    }

    private function updateUser(Transaction $transaction): void
    {
        $repository = new UserRepository();
        $repository->increaseCredit($transaction->getUser(), $transaction->getAmount());
    }
}