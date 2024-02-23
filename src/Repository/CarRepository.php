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

    /***********************************************
     * Trouve les annonces de voitures dans une plage de prix donnée.
     *
     * @param int|null $minPrice Le prix minimum
     * @param int|null $maxPrice Le prix maximum
     * @return Car[] Liste des annonces de voitures filtrées par prix
     */

    // Méthode pour filtrer les voitures en fonction d'une plage de prix
    //public function findByPriceRange($minPrice, $maxPrice, $minMileage, $maxMileage)
    public function findByPriceRange($minPrice, $maxPrice, $minMileage, $maxMileage, $minYear, $maxYear)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.Year', 'cy')
            ->where('c.Price >= :minPrice')
            ->andWhere('c.Price <= :maxPrice')
            ->andWhere('c.Mileage >= :minMileage')
            ->andWhere('c.Mileage <= :maxMileage')
            ->andWhere('cy.name >= :minYear')
            ->andWhere('cy.name <= :maxYear')
            ->setParameters([
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'minMileage' => $minMileage,
                'maxMileage' => $maxMileage,
                'minYear' => $minYear,
                'maxYear' => $maxYear,
            ])
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return Car[] Returns an array of Car objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val)
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
