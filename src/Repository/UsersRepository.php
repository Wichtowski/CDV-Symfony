<?php

namespace App\Repository;

use App\Entity\Users;
use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface; 
// use Doctrine\DBAL\Driver\Statement as DriverStatement;
// use Symfony\Bridge\Doctrine\Middleware\Debug\DBAL3\Statement;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use App\Entity\UserRole;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        $this->updatePassword($user, $newHashedPassword);
    }
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Users::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function updatePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Users) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findOneByEmail(string $email): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :e')
            ->setParameter('e', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByName(string $name): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.name = :n')
            ->setParameter('n', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllAuthors(): array
    {
        $sql = 'SELECT * FROM "users" WHERE CAST("roles" AS text) ~ :role';
        $result = $this->entityManager->getConnection()->executeQuery($sql, ['role' => 'ROLE_AUTHOR']);
        return $this->entityManager->getRepository(Users::class)->findBy(['id' => array_column($result->fetchAllAssociative(), 'id')]);
    }

    public function findAllAuthorArticles(int $id)
    {
        $sql = 'SELECT * FROM "users" WHERE CAST("roles" AS text) ~ :role AND "id" = :id';
        $result = $this->entityManager->getConnection()->executeQuery($sql, ['role' => 'ROLE_AUTHOR', 'id' => $id]);
        // dd($result->fetchAllAssociative());
        return $this->entityManager->getRepository(Articles::class)->findBy(['id' => array_column($result->fetchAllAssociative(), $id)]);
    }

    
    public function findAdmins()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :roles')
            ->setParameter('roles', '%' . UserRole::ROLES['Admin'] . '%')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Users[] Returns an array of Users objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Users
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
