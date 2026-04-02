<?php

namespace App\Controller\Commands;

use App\Entity\Users;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(name: 'user:delete', description: 'Delete a user by email')]
class DeleteUserCommandController extends Command
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();
        $this->addArgument('email', InputArgument::REQUIRED, 'The email of the user to delete');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $email = $input->getArgument('email');
        if (!$email) {
            $question = new Question('Please enter the email: ');
            $email = $helper->ask($input, $output, $question);
        }

        if (!$email) {
            $output->writeln('<error>Email argument is missing.</error>');
            return Command::FAILURE;
        }

        $user = $this->entityManager->getRepository(Users::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $output->writeln('<error>User not found.</error>');
            return Command::FAILURE;
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $output->writeln('User successfully deleted!');

        return Command::SUCCESS;
    }
}
