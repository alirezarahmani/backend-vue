<?php

namespace App\Infrastructure\Repositories\Redis;

use App\Domain\Events\TransactionCachedMissedEvent;
use Money\Money;
use App\Domain\Entity\Transaction;
use App\Domain\Events\TransactionSubscriber;
use App\Domain\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class TransactionRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addTransaction(Transaction $transaction): void
    {
        $key = $transaction->getFormattedDate();
        if (!$this->exists($transaction->getCreatedAt())) {
            $event = new TransactionCachedMissedEvent($transaction->getCreatedAt());
            $dispatcher = new EventDispatcher();
            $dispatcher->addSubscriber(new TransactionSubscriber());
            $dispatcher->dispatch($event, TransactionCachedMissedEvent::NAME);
        } else {
            $total = Money::EUR($this->client->get($key));
            $this->client->set($key, (intval($total->getAmount()) + intval($transaction->getAmount()->getAmount())));
        }
    }

    public function updateTotalDay(\DateTime $date, int $total): void
    {
        $key = Transaction::formatDate($date);
        $this->client->set($key, $total);
    }

    public function getAllOfDay(\DateTime $date): ?string
    {
        $key = Transaction::formatDate($date);
        return $this->client->get($key);
    }

    public function exists(\DateTime $date): int
    {
        $key = Transaction::formatDate($date);
        return $this->client->exists($key);
    }
}