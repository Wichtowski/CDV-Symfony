<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Authors;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $author1 = new Authors();
        $author1->setName('J.K. Rowling')
            ->setCategory('Fantasy');
        $manager->persist($author1); 

        $article1 = new Articles();
        $article1->setTitle('The Boy Who Lived')
            ->setContent('In a cupboard under the stairs, a young boy discovers his true heritage and embarks on a magical journey.')
            ->setAuthor($author1); 
        $manager->persist($article1); 
        
        $author2 = new Authors();
        $author2->setName('Stephen King')
            ->setCategory('Horror');
        $manager->persist($author2);

        $article2 = new Articles();
        $article2->setTitle('The Shining')
            ->setContent('A family heads to an isolated hotel for the winter where an evil presence influences the father into violence.')
            ->setAuthor($author2); 
        $manager->persist($article2);

        $author3 = new Authors();
        $author3->setName('H.P. Lovecraft')
            ->setCategory('Horror');
        $manager->persist($author3);

        $article3 = new Articles();
        $article3->setTitle('The Call of Cthulhu')
            ->setContent('An investigation into the ancient and monstrous entity known as Cthulhu leads to terrifying discoveries.')
            ->setAuthor($author3); 
        $manager->persist($article3);

        $manager->flush();
    }
}