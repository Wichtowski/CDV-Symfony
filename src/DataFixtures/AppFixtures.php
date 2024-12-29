<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Articles;
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
            ['name' => 'J.K. Rowling', 'email' => 'jk.rowling@example.com', 'password' => 'password123'],
            ['name' => 'George R.R. Martin', 'email' => 'george.martin@example.com', 'password' => 'password456'],
            ['name' => 'J.R.R. Tolkien', 'email' => 'tolkien@example.com', 'password' => 'password789'],
        ];

        $users = [];
        foreach ($usersData as $userData) {
            $user = new User();
            $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
            $user->setName($userData['name']);
            $user->setEmail($userData['email']);
            $user->setRole('author');
            $user->setPassword($hashedPassword);
            $manager->persist($user);
            $users[] = $user;
        }

        $manager->flush();

        $articlesData = [
            ['title' => 'Harry Potter', 'content' => 'A young wizard\'s journey begins.', 'author' => $users[0]],
            ['title' => 'A Game of Thrones', 'content' => 'A tale of power and betrayal in the Seven Kingdoms.', 'author' => $users[1]],
            ['title' => 'A Clash of Kings', 'content' => 'The Seven Kingdoms face new threats as winter approaches.', 'author' => $users[1]],
            ['title' => 'A Storm of Swords', 'content' => 'The war for the Iron Throne intensifies.', 'author' => $users[1]],
            ['title' => 'A Feast for Crows', 'content' => 'The aftermath of the war leaves the Seven Kingdoms in turmoil.', 'author' => $users[1]],
            ['title' => 'A Dance with Dragons', 'content' => 'New alliances and betrayals shape the fate of the Seven Kingdoms.', 'author' => $users[1]],
            ['title' => 'The Hobbit', 'content' => 'A hobbit\'s adventure to reclaim a lost kingdom.', 'author' => $users[2]],
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
