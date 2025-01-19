<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\Entity\Articles;
use App\Entity\Comments;
use App\Entity\UserRole;
use App\Repository\UsersRepository;
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
            ['name' => 'Alice Johnson', 'email' => 'alice.johnson@example.com', 'roles' => [UserRole::Guest]],
            ['name' => 'Bob Smith', 'email' => 'bob.smith@example.com', 'roles' => [UserRole::Subscriber]],
            ['name' => 'Charlie Brown', 'email' => 'charlie.brown@example.com', 'roles' => [UserRole::Author]],
            ['name' => 'Fiona Gallagher', 'email' => 'fiona.gallagher@example.com', 'roles' => [UserRole::Author]],
            ['name' => 'George Martin', 'email' => 'george.martin@example.com', 'roles' => [UserRole::Author]],
            ['name' => 'Diana Prince', 'email' => 'diana.prince@example.com', 'roles' => [UserRole::Moderator]],
            ['name' => 'Edward Norton', 'email' => 'edward.norton@example.com', 'roles' => [UserRole::Admin]],
            ['name' => 'Andrzej Sapkowski', 'email' => 'andrzej.sapkowski@example.com', 'roles' => [UserRole::Author]],
            ['name' => 'Steven Erikson', 'email' => 'steven.erikson@example.com', 'roles' => [UserRole::Author]],
            ['name' => 'Glen Cook', 'email' => 'glen.cook@example.com', 'roles' => [UserRole::Author]],
            ['name' => 'Sarah J. Maas', 'email' => 'sarah.maas@example.com', 'roles' => [UserRole::Subscriber]],
        ];

        $users = [];
        foreach ($usersData as $userData) {
            $user = new Users();
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'zaq1@WSX');
            $user->setName($userData['name']);
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);
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

        $articles = [];
        foreach ($articlesData as $articleData) {
            $article = new Articles();
            $article->setTitle($articleData['title']);
            $article->setContent($articleData['content']);
            $article->setAuthor($articleData['author']);
            $article->setCreatedAt(new \DateTime());
            $manager->persist($article);
            $articles[] = $article;
        }

        $userComments = [
            ['content' => 'Great article!', 'user' => $users[1], 'article' => $articles[0]],
            ['content' => 'I enjoyed reading this.', 'user' => $users[10], 'article' => $articles[1]],
            ['content' => 'Very informative.', 'user' => $users[1], 'article' => $articles[2]],
            ['content' => 'Looking forward to more articles.', 'user' => $users[10], 'article' => $articles[3]],
            ['content' => 'Keep up the good work.', 'user' => $users[1], 'article' => $articles[4]],
            ['content' => 'Interesting topic.', 'user' => $users[10], 'article' => $articles[5]],
            ['content' => 'I have a question.', 'user' => $users[1], 'article' => $articles[6]],
            ['content' => 'Can you recommend more resources?', 'user' => $users[1], 'article' => $articles[7]],
            ['content' => 'I would like to learn more about this.', 'user' => $users[10], 'article' => $articles[8]],
            ['content' => 'This is a great read.', 'user' => $users[1], 'article' => $articles[9]],
            ['content' => 'I have shared this with my friends.', 'user' => $users[10], 'article' => $articles[10]],
        ];

        foreach ($userComments as $commentData) {
            $comment = new Comments();
            $comment->setContent($commentData['content']);
            $comment->setUser($commentData['user']);
            $comment->setArticle($commentData['article']);
            $manager->persist($comment);
        }

        $manager->flush();
    }
}
