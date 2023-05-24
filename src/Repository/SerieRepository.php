<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Serie>
 *
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    const MAX_RESULT = 48;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function save(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Serie $entity, bool $flush = false): void
    {

        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBestSeries()
    {
        // en DQL
//    $entitymanager = $this->getEntityManager();
//    $dql = "SELECT s from App\Entity\Serie
//            AS s
//            WHERE s.vote >= 8.5
//            AND s.popularity > 200
//            ORDER BY s.popularity DESC ";
//
//    $query = $entitymanager-> createQuery($dql);

        //En QuerryBuilder
        $qb = $this->createQueryBuilder('s');
        $qb->addOrderBy('s.popularity', ' DESC')
            ->andWhere("s.vote >= 8")
            ->andWhere('s.popularity>100');

        $query = $qb->getQuery();

        $query->setMaxResults();
        return $query->getResult();
    }

    public function findSerieWithPagination(int $page)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->addOrderBy('s.popularity', ' DESC');
        $qb->leftJoin('s.seasons','seasons');


        // ne pas oublié !
        $qb->addSelect('seasons');





        $query = $qb->getQuery();
        $query->setMaxResults(SerieRepository::MAX_RESULT);
        $offset = ($page - 1) * SerieRepository::MAX_RESULT;
        $query->setFirstResult($offset);

        $paginator = new Paginator($query);

        return $paginator;
    }
}
