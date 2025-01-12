<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:my-command', description: 'My command description')]
class CommandController extends Command
{
    protected static $defaultName = 'app:my-command';

    protected function configure()
    {
        $this
            ->setDescription('My command description')
            ->setHelp('My command help')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hello World');

        return Command::SUCCESS;
    }
}
