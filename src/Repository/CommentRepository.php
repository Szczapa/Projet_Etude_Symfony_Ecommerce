<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Comment $entity, bool $flush = true): void
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
    public function remove(Comment $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findMyComment($idProduct, $user)
    {
        return $this->createQueryBuilder('o')
        // o.product = id du produit
        ->andWhere('o.product = :idProduct')
        // o.user = utilisateur actuel
        ->andWhere('o.user = :user')
        // Set de la valeur idProduct = à la valeur du produit affiché
        ->setParameter('idProduct', $idProduct)
        // Set de la valeur user = à la valeur du user connecté
        ->setParameter('user', $user)
         // On prend la requête
        ->getQuery()
        // On récupère le résultat
        ->getResult()
        ;
    }

    public function findCommentbyprod($idProduct)
    {
        return $this->createQueryBuilder('c')
        // c.product = id du produit
        ->andWhere('c.product = :idProduct')
        // Set de la valeur idProduct = à la valeur du produit affiché
        ->setParameter('idProduct', $idProduct)
        // Set des résultat par ordre décroissante
        ->orderBy('c.id', 'DESC')
        // On prend la requête
        ->getQuery()
        // On récupère le résultat
        ->getResult()
        ;
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
