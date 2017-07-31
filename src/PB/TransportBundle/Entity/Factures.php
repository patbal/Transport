<?php

namespace PB\TransportBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PB\TransportBundle\Entity\Transport;
use PB\TransportBundle\Entity\Transporteur;

/**
 * Factures
 *
 * @ORM\Table(name="trefactures")
 * @ORM\Entity(repositoryClass="PB\TransportBundle\Repository\FacturesRepository")
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
    private $numerofacture;

    /**
     * @var decimal
     *
     * @ORM\Column(name="montantfacture", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $montantfacture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefacture", type="datetime", nullable=true)
     */
    private $datefacture;

    /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\Transporteur")
     */
    private $transporteur;

     /**
     * @ORM\OneToMany(targetEntity="PB\TransportBundle\Entity\Transport", mappedBy="facture", cascade={"persist", "remove"})
    */
    private $transports;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->transports = new ArrayCollection();
        $this->datefacture = new \DateTime();
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
     * Set numerofacture
     *
     * @param string $numerofacture
     *
     * @return Factures
     */
    public function setNumerofacture($numerofacture)
    {
        $this->numerofacture = $numerofacture;

        return $this;
    }

    /**
     * Get numerofacture
     *
     * @return string
     */
    public function getNumerofacture()
    {
        return $this->numerofacture;
    }

    /**
     * Set montantfacture
     *
     * @param string $montantfacture
     *
     * @return Factures
     */
    public function setMontantfacture($montantfacture)
    {
        $this->montantfacture = $montantfacture;

        return $this;
    }

    /**
     * Get montantfacture
     *
     * @return string
     */
    public function getMontantfacture()
    {
        return $this->montantfacture;
    }

    /**
     * Set datefacture
     *
     * @param \DateTime $datefacture
     *
     * @return Factures
     */
    public function setDatefacture($datefacture)
    {
        $this->datefacture = $datefacture;

        return $this;
    }

    /**
     * Get datefacture
     *
     * @return \DateTime
     */
    public function getDatefacture()
    {
        return $this->datefacture;
    }

    /**
     * Set transporteur
     *
     * @param Transporteur $transporteur
     *
     * @return Factures
     */
    public function setTransporteur(Transporteur $transporteur = null)
    {
        $this->transporteur = $transporteur;

        return $this;
    }

    /**
     * Get transporteur
     *
     * @return Transporteur
     */
    public function getTransporteur()
    {
        return $this->transporteur;
    }

    /**
     * Add transport
     *
     * @param Transport $transport
     *
     * @return Factures
     */
    public function addTransport(Transport $transport)
    {
        $this->transports[] = $transport;
        $transport -> setFacture($this);

        return $this;
    }

    /**
     * Remove transport
     *
     * @param Transport $transport
     */
    public function removeTransport(Transport $transport)
    {
        $this->transports->removeElement($transport);
    }

    /**
     * Get transports
     *
     * @return Collection
     */
    public function getTransports()
    {
        return $this->transports;
    }
}
