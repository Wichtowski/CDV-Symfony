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
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'password123');
        
        $user->setName('J.K. Rowling');
        $user->setEmail('jk.rowling@example.com');
        $user->setRole('author');
        $user->setPassword($hashedPassword);

        $manager->persist($user);

        $user2 = new User();
        $hashedPassword2 = $this->passwordHasher->hashPassword($user2, 'password456');
        
        $user2->setName('George R.R. Martin');
        $user2->setEmail('george.martin@example.com');
        $user2->setRole('author');
        $user2->setPassword($hashedPassword2);

        $manager->persist($user2);

        $user3 = new User();
        $hashedPassword3 = $this->passwordHasher->hashPassword($user3, 'password789');
        
        $user3->setName('J.R.R. Tolkien');
        $user3->setEmail('tolkien@example.com');
        $user3->setRole('author');
        $user3->setPassword($hashedPassword3);

        $manager->persist($user3);
        $manager->flush();

        $article1 = new Articles();
        $article1->setTitle('Harry Potter');
        $article1->setContent('Content of the first Harry Potter book.');
        $article1->setShortDescription('A young wizard\'s journey begins.');
        $article1->setAuthor($user);
        $article1->setCreatedAt(new \DateTime());
        $manager->persist($article1);
        
        $article2 = new Articles();
        $article2->setTitle('A Game of Thrones');
        $article2->setContent('Content of the first book in A Song of Ice and Fire series.');
        $article2->setShortDescription('A tale of power and betrayal in the Seven Kingdoms.');
        $article2->setAuthor($user2);
        $article2->setCreatedAt(new \DateTime());
        $manager->persist($article2);
        
        $article3 = new Articles();
        $article3->setTitle('The Hobbit');
        $article3->setContent('Content of The Hobbit book...');
        $article3->setShortDescription('A hobbit\'s adventure to reclaim a lost kingdom.');
        $article3->setAuthor($user3);
        $article3->setCreatedAt(new \DateTime());
        $manager->persist($article3);
        
        $manager->flush();
    }
}
