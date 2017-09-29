<?php

namespace PB\CamionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeVehicule
 *
 * @ORM\Table(name="gescam_typevehicule")
 * @ORM\Entity(repositoryClass="PB\CamionBundle\Repository\TypeVehiculeRepository")
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
     * @ORM\Column(name="vehicule", type="string", length=30, unique=true)
     */
    private $vehicule;


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
     * Set vehicule
     *
     * @param string $vehicule
     *
     * @return TypeVehicule
     */
    public function setVehicule($vehicule)
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    /**
     * Get vehicule
     *
     * @return string
     */
    public function getVehicule()
    {
        return $this->vehicule;
    }
}
