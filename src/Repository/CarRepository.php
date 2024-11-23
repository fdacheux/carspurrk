<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\ORM\Query;
use App\Entity\CarSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Psr\Log\LoggerInterface;

/**
 * @extends ServiceEntityRepository<Car>
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,private LoggerInterface $logger)
    {
        parent::__construct($registry, Car::class);
    }

    public function findAllWithPagination(CarSearch $carSearch) : Query
    {
        
        $req = $this->createQueryBuilder('c');
        if($carSearch->getMinYear()) {
            $req = $req->andWhere('c.year >= :minYear')
            ->setParameter(':minYear', $carSearch->getMinYear());
        }
        if($carSearch->getMaxYear()) {
            $req = $req->andWhere('c.year <= :maxYear')
                ->setParameter(':maxYear', $carSearch->getMaxYear());
        };

        return $req->getQuery();
    }

    //    /**
    //     * @return Car[] Returns an array of Car objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Car
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
