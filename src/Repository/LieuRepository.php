<?php

namespace App\Repository;

use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lieu>
 *
 * @method Lieu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lieu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lieu[]    findAll()
 * @method Lieu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LieuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lieu::class);
    }


    public function listLieu()
    {
        $entityManager = $this->getEntityManager();
        $dql = "
        SELECT nom
        FROM APP\Entity\Lieu l
        INNER JOIN APP\Entity\Ville v 
        WHERE l.Ville = v.id
        ";
        $query = $entityManager->createQuery($dql);
        return $query;
    }


}
