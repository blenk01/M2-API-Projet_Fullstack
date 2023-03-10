<?php

namespace App\Repository;

use App\Entity\Graph1Data;
use App\Entity\Graph2Data;
use App\Entity\Sale;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sale>
 *
 * @method Sale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sale[]    findAll()
 * @method Sale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sale::class);
    }

    public function save(Sale $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sale $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getGraph1Data() {
        return $this->createQueryBuilder('s')
            ->select(
                sprintf('NEW %s(s.soldAt, AVG(s.value))', Graph1Data::class)
            )
            ->groupBy('s.soldAt')
            ->getQuery()
            ->getResult();
    }

    public function getNbVenteFilterDates(DateTime $startAt, DateTime $endAt) {
        return $this->createQueryBuilder('s')
            ->select(
                sprintf('NEW %s(s.soldAt, COUNT(s.soldAt))', Graph2Data::class),
            )
            ->where('s.soldAt <= :endAt and s.soldAt >= :startAt')
            ->setParameter('startAt', $startAt)
            ->setParameter('endAt', $endAt)
            ->groupBy('s.soldAt')
            ->getQuery()
            ->getResult();
    }
}
