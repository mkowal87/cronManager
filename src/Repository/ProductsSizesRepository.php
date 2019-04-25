<?php

namespace App\Repository;

use App\Entity\ProductsSizes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductsSizes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductsSizes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductsSizes[]    findAll()
 * @method ProductsSizes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsSizesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductsSizes::class);
    }

    // /**
    //  * @return ProductsSizes[] Returns an array of ProductsSizes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductsSizes
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
