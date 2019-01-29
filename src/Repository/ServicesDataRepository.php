<?php

namespace App\Repository;

use App\Entity\ServicesData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ServicesData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServicesData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServicesData[]    findAll()
 * @method ServicesData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicesDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ServicesData::class);
    }

    // /**
    //  * @return ServicesData[] Returns an array of ServicesData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServicesData
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
