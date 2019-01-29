<?php

namespace App\Repository;

use App\Entity\ContactData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContactData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactData[]    findAll()
 * @method ContactData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContactData::class);
    }

    // /**
    //  * @return ContactData[] Returns an array of ContactData objects
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
    public function findOneBySomeField($value): ?ContactData
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
