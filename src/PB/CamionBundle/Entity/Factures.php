<?php

namespace PB\CamionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PB\TransportBundle\Entity\Transport;
use PB\TransportBundle\Entity\Transporteur;

/**
 * Factures
 *
 * @ORM\Table(name="gescam_factures")
 * @ORM\Entity(repositoryClass="PB\CamionBundle\Repository\FacturesRepository")
 */
class Factures
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
     * @ORM\Column(name="numerofacture", type="string", length=255)
     */
    private $numeroFacture;

    /**
     * @var decimal
     *
     * @ORM\Column(name="montantfacture", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $montantFacture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefacture", type="datetime", nullable=true)
     */
    private $dateFacture;

    /**
     * @ORM\ManyToOne(targetEntity="PB\CamionBundle\Entity\Loueur")
     */
    private $loueur;

    /**
     * @ORM\OneToMany(targetEntity="PB\CamionBundle\Entity\Camion", mappedBy="facture", cascade={"all"})
     */
    private $locations;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->dateFacture = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numeroFacture
     *
     * @param string $numeroFacture
     *
     * @return Factures
     */
    public function setNumeroFacture($numeroFacture)
    {
        $this->numeroFacture = $numeroFacture;

        return $this;
    }

    /**
     * Get numeroFacture
     *
     * @return string
     */
    public function getNumeroFacture()
    {
        return $this->numeroFacture;
    }

    /**
     * Set montantFacture
     *
     * @param string $montantFacture
     *
     * @return Factures
     */
    public function setMontantFacture($montantFacture)
    {
        $this->montantFacture = $montantFacture;

        return $this;
    }

    /**
     * Get montantFacture
     *
     * @return string
     */
    public function getMontantFacture()
    {
        return $this->montantFacture;
    }

    /**
     * Set dateFacture
     *
     * @param \DateTime $dateFacture
     *
     * @return Factures
     */
    public function setDateFacture($dateFacture)
    {
        $this->dateFacture = $dateFacture;

        return $this;
    }

    /**
     * Get dateFacture
     *
     * @return \DateTime
     */
    public function getDateFacture()
    {
        return $this->dateFacture;
    }

    /**
     * Set loueur
     *
     * @param \PB\CamionBundle\Entity\Loueur $loueur
     *
     * @return Factures
     */
    public function setLoueur(\PB\CamionBundle\Entity\Loueur $loueur = null)
    {
        $this->loueur = $loueur;

        return $this;
    }

    /**
     * Get loueur
     *
     * @return \PB\CamionBundle\Entity\Loueur
     */
    public function getLoueur()
    {
        return $this->loueur;
    }


    /**
     * @param Camion $location
     * @return $this
     */
    public function addLocation(\PB\CamionBundle\Entity\Camion $location)
    {
        $this->locations[] = $location;
        $location -> setFacture($this);

        return $this;
    }

    /**
     * Remove location
     *
     * @param \PB\CamionBundle\Entity\Camion $location
     */
    public function removeLocation(\PB\CamionBundle\Entity\Camion $location)
    {
        $this->locations->removeElement($location);
    }

    /**
     * Get locations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocations()
    {
        return $this->locations;
    }
}
