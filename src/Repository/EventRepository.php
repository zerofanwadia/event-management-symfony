<?php

namespace App\Repository;

use App\Entity\Event;
use App\Model\EventFiltrer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Event[] Returns an array of Event objects
    */

    public function findByFilter(EventFiltrer $eventFilter) {
        $queryBuilder=$this->createQueryBuilder('e');

        if($eventFilter->getTitre()){
            $queryBuilder=$queryBuilder
                ->andWhere('e.titre LIKE :nom')
                ->setParameter('nom', '%'.$eventFilter->getTitre().'%');
        }
        if($eventFilter->getLieu()) {
            $queryBuilder=$queryBuilder
                ->andWhere('e.lieu LIKE :lieu')
                ->setParameter('lieu', '%'.$eventFilter->getLieu().'%');
        }
        if($eventFilter->getStartDate()) {
            $queryBuilder=$queryBuilder
                ->andWhere("e.date >= :start_date")
                ->setParameter('start_date', $eventFilter->getStartDate()->format('Y-m-d 00:00:00'));
        }
        if($eventFilter->getEndDate()) {
            $queryBuilder=$queryBuilder
                ->andWhere("e.date <= :end_date")
                ->setParameter('end_date', $eventFilter->getEndDate()->format('Y-m-d 00:00:00'));
        }
    
        return $queryBuilder->getQuery()->getResult();            
    }
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
