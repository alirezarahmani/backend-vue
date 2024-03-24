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
        $key = $this->getKey($transaction->getCreatedAt());
        if (!$this->exists($key)) {
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
        $this->client->set($this->getKey($date), $total);
    }

    public function getAllOfDay(\DateTime $date): ?string
    {
        return $this->client->get($this->getKey($date));
    }

    public function exists(string $key): int
    {
        return $this->client->exists($key);
    }

    public function getKey(\DateTime $date): string
    {
        return Transaction::formatDate($date);
    }
}
