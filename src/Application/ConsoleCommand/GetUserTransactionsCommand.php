<?php

namespace App\Application\ConsoleCommand;

use App\Domain\Services\GetUserTransactionService;
use App\Infrastructure\Repositories\MeekroDB\TransactionRepository;
use Assert\Assertion;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user-transactions',
    description: 'user transaction',
    aliases: ['app:u-t'],
    hidden: false
)]
class GetUserTransactionsCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $id = $input->getArgument('user');
            $date = $input->getArgument('date');
            Assertion::date($date, 'Y-m-d', 'wrong date',);
            $service = new GetUserTransactionService(new TransactionRepository());
            $output->writeln(' user has total amount of transactions: ' . $service->get($id, new \DateTime($date)) . '   on the day');
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
            ->setHelp('This command allows you to get transactions of a user in a day...')
            ->addArgument('user', InputArgument::REQUIRED, 'Who do you want to know? insert id')
            ->addArgument('date', InputArgument::REQUIRED, 'which day?');
    }
}