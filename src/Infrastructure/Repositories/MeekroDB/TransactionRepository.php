<?php

namespace App\Infrastructure\Repositories\MeekroDB;

use App\Domain\Entity\Transaction;
use App\Domain\Events\TransactionAddedEvent;
use App\Domain\Events\TransactionSubscriber;
use App\Domain\RepositoryInterface;
use DB;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class TransactionRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct()
    {
        parent::__construct('transactions');
    }

    public function add(Transaction $transaction): void
    {
        DB::insert($this->table, [
            'id' => $transaction->getId(),
            'user_id' => $transaction->getUser()->getId(),
            'amount' => $transaction->getAmount()->getAmount(),
            'createdAt' => $transaction->getCreatedAt()->format("Y-m-d H:i:s")
        ]);

        $event = new TransactionAddedEvent($transaction);
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new TransactionSubscriber());
        $dispatcher->dispatch($event, TransactionAddedEvent::NAME);
    }

    public function getTotalOfUserInDay(UuidInterface $userId, \DateTime $dateTime): array
    {
        return DB::query("select sum(amount) as total, users.id from $this->table join users on users.id = user_id where user_id = %s_userId and date($this->table.createdAt) = %s_date", [
            'userId' => $userId->toString(),
            'date' => $dateTime->format('Y-m-d')
        ]);
    }

    public function getTotalInDay(\DateTime $dateTime): array
    {
        return DB::query("select sum(amount) as total from $this->table where date($this->table.createdAt) = %s_date", [
            'date' => $dateTime->format('Y-m-d')
        ]);
    }
}