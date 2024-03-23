<?php

namespace App\Application\ConsoleCommand;

use App\Domain\Services\AddTransactionService;
use App\Infrastructure\Repositories\MeekroDB\TransactionRepository;
use App\Infrastructure\Repositories\MeekroDB\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:add-transaction',
    description: 'add transaction',
    aliases: ['app:a-t'],
    hidden: false
)]
class AddTransaction extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $id = $input->getArgument('user');
            $amount = $input->getArgument('amount');
            $service = new AddTransactionService(new UserRepository(), new TransactionRepository());
            $service->add($id, $amount);

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
            ->setHelp('This command allows you to add a transaction...')
            ->addArgument('user', InputArgument::REQUIRED, 'Who do you want to pay? insert id')
            ->addArgument('amount', InputArgument::REQUIRED, 'how much?');
    }
}