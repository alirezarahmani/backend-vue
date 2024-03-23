<?php

namespace unit;

use App\Domain\Entity\Transaction;
use App\Domain\Services\AddTransactionService;
use App\Infrastructure\Repositories\MeekroDB\TransactionRepository;
use App\Infrastructure\Repositories\MeekroDB\UserRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Ramsey\Uuid\Uuid;

class AddTransactionServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testAddTransactionWithValidUserIdAndAmount()
    {
        $userId = Uuid::uuid4()->toString();
        $amount = 100;

        $userRepo = $this->prophesize(UserRepository::class);
        $transactionRepo = $this->prophesize(TransactionRepository::class);

        $userRepo->findById(Uuid::fromString($userId))->willReturn([
            ['id' => $userId, 'name' => 'John Doe', 'credit' => 500]
        ]);
        $transactionRepo->add(Argument::type(Transaction::class))->shouldBeCalled();

        $service = new AddTransactionService($userRepo->reveal(), $transactionRepo->reveal());
        $service->add($userId, $amount);
    }

    public function testAddTransactionWithInvalidUserId()
    {
        $userId = '9141c3b9-39f9-4291-8b62-41003000aae4';
        $amount = 100;

        $userRepo = $this->prophesize(UserRepository::class);
        $transactionRepo = $this->prophesize(TransactionRepository::class);

        $userRepo->findById(Uuid::fromString($userId))->willReturn([]);
        $transactionRepo->add(Argument::type(Transaction::class))->shouldNotBeCalled();

        $service = new AddTransactionService($userRepo->reveal(), $transactionRepo->reveal());

        $this->expectException(\InvalidArgumentException::class);
        $service->add($userId, $amount);
    }

    public function testAddTransactionWithZeroAmount()
    {
        $userId = Uuid::uuid4()->toString();
        $amount = 0;

        $userRepo = $this->prophesize(UserRepository::class);
        $transactionRepo = $this->prophesize(TransactionRepository::class);

        $userRepo->findById(Uuid::fromString($userId))->willReturn([
            ['id' => $userId, 'name' => 'John Doe', 'credit' => 500]
        ]);
        $transactionRepo->add(Argument::type(Transaction::class))->shouldNotBeCalled();

        $service = new AddTransactionService($userRepo->reveal(), $transactionRepo->reveal());

        $this->expectException(\InvalidArgumentException::class);
        $service->add($userId, $amount);
    }
}