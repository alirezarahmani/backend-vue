<?php

namespace unit;

use App\Domain\Services\GetAllTransactionService;
use App\Infrastructure\Repositories\Redis\TransactionRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class GetAllTransactionServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testGetAllTransactionsForExistingDate()
    {
        $date = new \DateTime('2024-02-15');
        $repository = $this->prophesize(TransactionRepository::class);
        $repository->exists($date)->willReturn(true);
        $repository->getAllOfDay($date)->willReturn(10);

        $service = new GetAllTransactionService($repository->reveal());
        $result = $service->get($date);

        $this->assertEquals(10, $result);
    }

    public function testGetAllTransactionsForMissingDate()
    {
        // TODO: add more tests
    }
}