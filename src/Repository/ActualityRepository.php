<?php

namespace App\Repository;

use App\Entity\Actuality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Actuality>
 *
 * @method Actuality|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actuality|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actuality[]    findAll()
 * @method Actuality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actuality::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Actuality $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Actuality $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findPostByDate()
    {
        return $this->createQueryBuilder('a')
        ->andWhere('a.post = :post ')
        ->setParameter('post', 1)    
        ->orderBy('a.createdAt', 'DESC')
        ->getQuery()
        ->getResult()
        ;
    }
    // /**
    //  * @return Actuality[] Returns an array of Actuality objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Actuality
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
