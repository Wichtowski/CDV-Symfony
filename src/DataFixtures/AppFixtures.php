<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\Entity\Articles;
use App\Entity\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ['name' => 'Alice Johnson', 'email' => 'alice.johnson@example.com', 'roles' => UserRole::ROLES['Guest']],
            ['name' => 'Bob Smith', 'email' => 'bob.smith@example.com', 'roles' => UserRole::ROLES['Subscriber']],
            ['name' => 'Charlie Brown', 'email' => 'charlie.brown@example.com', 'roles' => UserRole::ROLES['Author']],
            ['name' => 'Fiona Gallagher', 'email' => 'fiona.gallagher@example.com', 'roles' => UserRole::ROLES['Author']],
            ['name' => 'George Martin', 'email' => 'george.martin@example.com', 'roles' => UserRole::ROLES['Author']],
            ['name' => 'Diana Prince', 'email' => 'diana.prince@example.com', 'roles' => UserRole::ROLES['Moderator']],
            ['name' => 'Edward Norton', 'email' => 'edward.norton@example.com', 'roles' => UserRole::ROLES['Admin']],
        ];

        $users = [];
        foreach ($usersData as $userData) {
            $user = new Users();
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'zaq1@WSX');
            $user->setName($userData['name']);
            $user->setEmail($userData['email']);
            $user->setRoles([$userData['roles']]);
            $user->setPassword($hashedPassword);
            $manager->persist($user);
            $users[] = $user;
        }
        
        $manager->flush();
        $articlesData = [
            ['title' => 'Quantum Mechanics', 'content' => 'An introduction to quantum mechanics.', 'author' => $users[2]],
            ['title' => 'Relativity Theory', 'content' => 'Understanding the theory of relativity.', 'author' => $users[2]],
            ['title' => 'String Theory', 'content' => 'Exploring the concepts of string theory.', 'author' => $users[2]],
            ['title' => 'Artificial Intelligence', 'content' => 'The future of AI and machine learning.', 'author' => $users[3]],
            ['title' => 'Cybersecurity', 'content' => 'Protecting data in the digital age.', 'author' => $users[3]],
            ['title' => 'Space Exploration', 'content' => 'The latest developments in space exploration.', 'author' => $users[2]],
            ['title' => 'Genetic Engineering', 'content' => 'The potential and risks of genetic engineering.', 'author' => $users[2]],
            ['title' => 'Climate Change', 'content' => 'The impact of climate change on our planet.', 'author' => $users[4]],
            ['title' => 'Renewable Energy', 'content' => 'The rise of renewable energy sources.', 'author' => $users[4]],
            ['title' => 'Blockchain Technology', 'content' => 'How blockchain is revolutionizing industries.', 'author' => $users[4]],
            ['title' => 'Virtual Reality', 'content' => 'The future of virtual reality technology.', 'author' => $users[3]],
            ['title' => 'Augmented Reality', 'content' => 'Applications of augmented reality in various fields.', 'author' => $users[3]],
        ];

        foreach ($articlesData as $articleData) {
            $article = new Articles();
            $article->setTitle($articleData['title']);
            $article->setContent($articleData['content']);
            $article->setAuthor($articleData['author']);
            $article->setCreatedAt(new \DateTime());
            $manager->persist($article);
        }

        $manager->flush();
    }
}
