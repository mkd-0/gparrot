<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }


    public function findFilteredCarsIds(
        $minPrice,
        $maxPrice,
        $minMileage,
        $maxMileage,
        $minYear,
        $maxYear
    ): array {
        $query = $this->createQueryBuilder('c');
        return $query->select('c.id')
            ->where('c.Price BETWEEN :minPrice AND :maxPrice')
            //->andWhere('c.Price < :maxPrice')
            // ->andWhere('c.Mileage >= :minMileage')
            // ->andWhere('c.Mileage <= :maxMileage')
            // ->andWhere('c.Year >= :minYear')
            // ->andWhere('c.Year <= :maxYear')
            ->setParameter('minPrice', $minPrice)
            ->setParameter('maxPrice', $maxPrice)
            // ->setParameter('minMileage', $minMileage)
            // ->setParameter('maxMileage', $maxMileage)
            // ->setParameter('minYear', $minYear)
            // ->setParameter('maxYear', $maxYear)
            ->getQuery()
            ->getResult();
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
