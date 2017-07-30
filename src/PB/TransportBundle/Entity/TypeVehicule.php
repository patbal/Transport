<?php

namespace PB\TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * typeVehicule
 *
 * @ORM\Table(name="tre_type_vehicule")
 * @ORM\Entity(repositoryClass="PB\TransportBundle\Repository\TypeVehiculeRepository")
 */
class TypeVehicule
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="typevehicule", type="string", length=255, unique=true)
     */
    private $typevehicule;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set typevehicule
     *
     * @param string $typevehicule
     *
     * @return typeVehicule
     */
    public function setTypevehicule($typevehicule)
    {
        $this->typevehicule = $typevehicule;

        return $this;
    }

    /**
     * Get typevehicule
     *
     * @return string
     */
    public function getTypevehicule()
    {
        return $this->typevehicule;
    }
}

