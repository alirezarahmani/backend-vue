<?php

namespace App\Infrastructure\Repositories\MeekroDB;

use App\Domain\Entity\User;
use DB;
use Money\Money;
use App\Domain\RepositoryInterface;
use Ramsey\Uuid\UuidInterface;

readonly class UserRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function addUser(User $user): void
    {
        DB::insert($this->table, ['id' => $user->getId(), 'name' => $user->getName(), 'credit' => 0, 'createdAt' => $user->getCreatedAt()->format("Y-m-d H:i:s")]);
    }

    public function increaseCredit(User $user, Money $amount)
    {
        $amount = $user->getCredit()->add($amount);
        DB::update($this->table, ['credit' => $amount->getAmount()], "id=%s", $user->getId());
    }

    public function findById(UuidInterface $id): array
    {
        return DB::query("SELECT * FROM $this->table WHERE id=%s_id",
            [
                'id' => $id,
            ]
        );
    }
}