<?php

namespace unit;

use App\Domain\Services\GetUserTransactionService;
use App\Infrastructure\Repositories\MeekroDB\TransactionRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Ramsey\Uuid\Uuid;

class GetUserTransactionServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testGetUserTransaction()
    {
        $repository = $this->prophesize(TransactionRepository::class);

        $userId = Uuid::uuid4()->toString();
        $date = new \DateTime();

        $expectedResult = [
            ['id' => 1, 'total' => 100], // Sample result from the repository
        ];

        $repository->getTotalOfUserInDay(Uuid::fromString($userId), $date)->willReturn($expectedResult);
        $service = new GetUserTransactionService($repository->reveal());

        $result = $service->get($userId, $date);
        $this->assertEquals(100, $result);
    }

    public function testGetUserTransactionWithInvalidUserId()
    {
        // Mocking the repository
        $repository = $this->prophesize(TransactionRepository::class);

        $userId = '9141c3b9-39f9-4291-8b62-4100390aaae4';
        $date = new \DateTime();

        $repository->getTotalOfUserInDay(Uuid::fromString($userId), $date)->willReturn([]);
        $service = new GetUserTransactionService($repository->reveal());

        $this->expectException(\InvalidArgumentException::class);
        $service->get($userId, $date);
    }
}
