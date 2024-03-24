<?php

namespace unit;

use App\Application\ConsoleCommand\AddTransaction;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class AddTransactionTest extends TestCase
{
    public function testExecuteAddsTransactionSuccessfully()
    {
        $application = new Application();
        $application->add(new AddTransaction());

        $command = $application->find('app:add-transaction');
        $commandTester = new CommandTester($command);

        $userId = 'd416f1d3-eaa8-4037-91b4-91191827452d';
        $amount = '100';

        $commandTester->execute([
            'command' => $command->getName(),
            'user' => $userId,
            'amount' => $amount,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Transaction added successfully', $output);
    }
}