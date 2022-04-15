<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Event $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Event $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Event[] Returns an array of Event objects
     */
    public function findLastEvents(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.date_fin', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneById(int $id): ?Event
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.userEvents', 'ue')->addSelect('ue')
            ->leftJoin('ue.user', 'u')->addSelect('u')
            ->leftJoin('e.messageActivites', 'ma')->addSelect('ma')
            ->andWhere('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
