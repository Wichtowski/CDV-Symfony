<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;

#[AsCommand(name: 'create:user', description: 'My command description')]
class CommandController extends Command
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the new user')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the new user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $email = $input->getArgument('email');
        if (!$email) {
            $question = new Question('Please enter the email: ');
            $email = $helper->ask($input, $output, $question);
        }

        $password = $input->getArgument('password');
        if (!$password) {
            $question = new Question('Please enter the password: ');
            $question->setHidden(true);
            $question->setHiddenFallback(false);
            $password = $helper->ask($input, $output, $question);
        }

        if (!$email || !$password) {
            $output->writeln('<error>Not enough arguments (missing: "email, password").</error>');
            return Command::FAILURE;
        }
    
        $user = new Users();
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
    
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    
        $output->writeln('User successfully generated!');
    
        return Command::SUCCESS;
    }
}
