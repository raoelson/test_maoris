<?php

namespace Test\AppBundle\Repository;

/**
 * TypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TypeRepository extends \Doctrine\ORM\EntityRepository {
    
    public function getAll() {
        $qB = $this->createQueryBuilder('t')
                ->leftJoin('t.users', 'u')
                ->addSelect('u');
        return $qry = $qB->getQuery()->getResult();
    }
}
