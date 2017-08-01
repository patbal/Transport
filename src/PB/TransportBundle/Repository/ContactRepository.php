<?php

namespace PB\TransportBundle\Repository;


/**
 * ContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends \Doctrine\ORM\EntityRepository
{
	public function getContactByAdress($id)
	{
		return $query = $this -> createQueryBuilder('c')
			-> where('c.adress = ?1')
			-> setParameter(1, $id)
			-> getQuery()
			-> getResult();
	}

	public function getContacts()
    {
        $qb = $this ->createQueryBuilder('c')
            -> orderBy('c.nom');
        return $qb -> getQuery()->getResult();
    }
	
}
