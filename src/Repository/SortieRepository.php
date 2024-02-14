<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\String\s;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function allTables()
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder->addOrderBy('s.nom', 'ASC');
        $queryBuilder->join('s.organisateur', 'orga');
        $queryBuilder->join('s.Etat', 'etat');
        $queryBuilder->LeftJoin('s.Participant', 'part');
        $queryBuilder->addSelect('orga');
        $queryBuilder->addSelect('etat');
        $queryBuilder->addSelect('part');

        $query = $queryBuilder->getQuery();
        $query->setMaxResults(20);
        $results = $query->getResult();
        return $results;
    }

    public function searchByName($search)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder->addOrderBy('s.nom', 'ASC');
        $queryBuilder->join('s.organisateur', 'orga');
        $queryBuilder->join('s.Etat', 'etat');
        $queryBuilder->LeftJoin('s.Participant', 'part');
        $queryBuilder->addSelect('orga');
        $queryBuilder->addSelect('etat');
        $queryBuilder->addSelect('part');

        $queryBuilder->andWhere('s.Campus = :campus');
        $queryBuilder->setParameter('campus', $search['campus']);

        $queryBuilder->andWhere('s.nom LIKE :search');
        $queryBuilder->setParameter('search', '%' . $search['search'] . '%');

        $queryBuilder->andWhere('s.dateHeureDebut BETWEEN :date1 AND :date2');
        $queryBuilder->setParameter('date1', $search['date1']);
        $queryBuilder->setParameter('date2', $search['date2']);



        $query = $queryBuilder->getQuery();
        $query->setMaxResults(20);
        $results = $query->getResult();
        return $results;
    }

}
