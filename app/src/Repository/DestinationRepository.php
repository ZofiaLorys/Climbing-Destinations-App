<?php

namespace App\Repository;

use App\Entity\Destination;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class DestinationRepository
 *
 * @method Destination|null find($id, $lockMode = null, $lockVersion = null)
 * @method Destination|null findOneBy(array $criteria, array $orderBy = null)
 * @method Destination[]    findAll()
 * @method Destination[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DestinationRepository extends ServiceEntityRepository
{

    /**
     * DestinationRepository constructor.
     *
     * @param \Symfony\Bridge\Doctrine\RegistryInterface $registry Registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Destination::class);
    }


    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {

            return $this->getOrCreateQueryBuilder()
                ->orderBy('destinationTable.id', 'DESC')
                ->join('destinationTable.rankings', 'rankingTable')
                ->join('destinationTable.country', 'countryTable')
                ->join('destinationTable.author', 'userTable')
                ->join('rankingTable.grade', 'gradeTable');


    }


    /**
     * @param User|null $user
     * @return QueryBuilder
     */
    public function queryByAuthor(User $user = null): QueryBuilder
    {
        $queryBuilder = $this->queryAll();

        if (!is_null($user)) {
            $queryBuilder->andWhere('destinationTable.author = :author')
                ->setParameter('author', $user);
        }

        return $queryBuilder;
    }


#SELECT AVG(value), destination_id FROM rankings NATURAL JOIN grades WHERE destination_id = 705 GROUP BY destination_id ;

    public function queryAllWithAvgRanking(): QueryBuilder
    {
        $queryBuilder = $this->queryAll();
        $queryBuilder
            ->select('AVG(gradeTable.value) as average, destinationTable.id, countryTable.title AS country, destinationTable.title, destinationTable.description, userTable.fullName AS author')
            ->groupBy('rankingTable.destination');
        return $queryBuilder;
    }


/*
#SELECT AVG(value), destination_id FROM rankings NATURAL JOIN grades WHERE destination_id = 705 GROUP BY destination_id ;
    public function average_destination(): QueryBuilder
    {

        return $this->getOrCreateQueryBuilder()
            ->select("avg(r.value)")
            #->innerJoin('r', 'grades', 'g', 'r.grade_id = g.id')
            ->join('r.grades', 'g')
            ->groupBy('r.destination_id');

    }
/*

    /**
     * Save record.
     *
     * @param \App\Entity\Destination $destination Destination entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Destination $destination): void
    {
        $this->_em->persist($destination);
        $this->_em->flush($destination);
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Destination $destination Destination entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Destination $destination): void
    {
        $this->_em->remove($destination);
        $this->_em->flush($destination);
    }

    /**
     * Get or create new query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?: $this->createQueryBuilder('destinationTable');
    }

    // /**
    //  * @return Destination[] Returns an array of Destination objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Destination
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ->orderBy('t.id', 'DESC')->join('t.country','c');
            ;
        $queryAvgScore = $queryScore->createQueryBuilder('g')
    */
#SELECT AVG(value), destination_id FROM rankings NATURAL JOIN grades WHERE destination_id = 705 GROUP BY destination_id ;    public function averageGrade($value): ?Destination

}


