<?php

namespace App\Core\User\UserInterface\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Core\User\Application\Query\GetInactiveUsers\GetInactiveUsersQuery;
use App\Common\Bus\QueryBusInterface;

#[AsCommand(
    name: 'app:user:get-inactive-users-emails',
    description: 'Wyświetlanie emaili nieaktywnych użytkowników'
)]
class GetInactiveUsersEmails extends Command
{
    public function __construct(private readonly QueryBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->bus->dispatch(new GetInactiveUsersQuery);
        foreach ($users as $user) {
            $output->writeln($user->email);
        }

        return Command::SUCCESS;
    }
}