<?php

namespace unit;

use App\Application\ConsoleCommand\GetTotalTransactionsCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class GetTotalTransactionsCommandTest extends TestCase
{
    public function testExecuteRetrievesTotalTransactionsSuccessfully()
    {
        $application = new Application();
        $application->add(new GetTotalTransactionsCommand());

        $command = $application->find('app:all-transactions');
        $commandTester = new CommandTester($command);

        $date = '2024-03-01';

        $commandTester->execute([
            'command' => $command->getName(),
            'date' => $date,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('on this day total amount of all transactions is:', $output);
    }
}
