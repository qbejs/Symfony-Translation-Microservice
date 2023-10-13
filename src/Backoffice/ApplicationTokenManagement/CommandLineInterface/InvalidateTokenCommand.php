<?php

namespace App\Backoffice\ApplicationTokenManagement\CommandLineInterface;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'backoffice:application-token:invalidate',
    description: 'Invalidate an application token',
)]
class InvalidateTokenCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info('Invalidate Token Command');

        return Command::SUCCESS;
    }
}
