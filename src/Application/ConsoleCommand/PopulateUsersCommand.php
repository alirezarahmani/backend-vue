<?php

namespace App\Application\ConsoleCommand;

use App\Infrastructure\Repositories\MeekroDB\TransactionRepository;
use App\Infrastructure\Repositories\MeekroDB\UserRepository;
use App\Infrastructure\Services\FakerService;
use Assert\AssertionFailedException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:populate-users',
    description: 'Creates many new users randomly.',
    aliases: ['app:p-u'],
    hidden: false
)]
class PopulateUsersCommand  extends Command
{
    /**
     * @throws AssertionFailedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $faker = new FakerService(new UserRepository(), new TransactionRepository());
            $faker->populate(rand(10, 100));
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
            ->setHelp('This command allows you to create users randomly...')
        ;
    }
}