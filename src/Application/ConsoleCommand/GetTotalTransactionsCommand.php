<?php

namespace App\Application\ConsoleCommand;

use App\Domain\Services\GetAllTransactionService;
use App\Infrastructure\Repositories\Redis\TransactionRepository as TransactionRedisRepository;
use Assert\Assertion;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:all-transactions',
    description: 'all transactions.',
    aliases: ['app:all-t'],
    hidden: false
)]
class GetTotalTransactionsCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $date = $input->getArgument('date');
            Assertion::date($date, 'Y-m-d', 'wrong date');
            $service = new GetAllTransactionService(new TransactionRedisRepository());
            $output->writeln(' on this day total amount of all transactions is: ' . $service->get(new \DateTime($date)) . ' ');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to get transactions in a day...')
            ->addArgument('date', InputArgument::REQUIRED, 'which day?');
    }
}