<?php

namespace PB\CamionBundle\Repository;

/**
 * FacturesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FacturesRepository extends \Doctrine\ORM\EntityRepository
{
    public function getFactures()
    {
        $query = $this->createQueryBuilder('f')
            ->orderBy('f.id', 'DESC');

        return $query;
    }
}
