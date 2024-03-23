<?php

namespace unit;

use App\Infrastructure\Repositories\MeekroDB\TransactionRepository;
use App\Infrastructure\Repositories\MeekroDB\UserRepository;
use App\Infrastructure\Services\FakerService;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class FakerServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testPopulate()
    {
        // TODO: add more tests
    }

    public function testPopulateWithInvalidNumber()
    {
        $userRepository = $this->prophesize(UserRepository::class);
        $transactionRepository = $this->prophesize(TransactionRepository::class);

        $fakerService = new FakerService($userRepository->reveal(), $transactionRepository->reveal());

        $this->expectException(\InvalidArgumentException::class);
        $fakerService->populate(0);
    }
}
