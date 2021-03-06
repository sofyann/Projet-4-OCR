<?php

namespace AppBundle\Repository;

/**
 * CommandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
use DateTime;
class CommandeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findLastOne(){
        return $this->createQueryBuilder('commande')
            ->orderBy('commande.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->execute();
    }

    public function findByDate(DateTime $date){
        return $this->createQueryBuilder('commande')
            ->andWhere('commande.dateDeVisite = :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->execute();
    }
}
