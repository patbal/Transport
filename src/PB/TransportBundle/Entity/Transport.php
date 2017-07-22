<?php

namespace PB\TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transport
 *
 * @ORM\Table(name="tretransport")
 * @ORM\Entity(repositoryClass="PB\TransportBundle\Repository\TransportRepository")
 */
class Transport
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
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateenlevement", type="datetime")
     */
    private $dateenlevement;

    /**
     * @var \datetime
     *
     * @ORM\Column(name="datelivraison", type="datetime")
     */
     
    private $datelivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="text")
     */
    private $remarque;

    /**
     * @var string
     *
     * @ORM\Column(name="operation", type="string", length=255)
     */
    private $operation;

    /**
     * @var bool
     *
     * @ORM\Column(name="effectue", type="boolean")
     */
    private $effectue;

    /**
     * @var bool
     *
     * @ORM\Column(name="annule", type="boolean")
     */
    private $annule;

    /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\Transporteur")
     */
    private $transporteur;

    /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\Adresse")
     */
    private $adresseFrom;

    /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\Adresse")
     */
    private $adresseTo;

    /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\Contact")
     */
    private $contactFrom;

    /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\Contact")
     */
    private $contactTo;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255)
     */
    private $number;


    /**
     * Get id
     *
     * @return int
     */
    
    public function __construct()
    {
        $now = new \DateTime();
        $this->number = 'TR'.$now->format('Y').$now->format('m').'-';
        $this->datecreation = new \DateTime();
        $this->dateenlevement = new \DateTime();
        $this->datelivraison = new \DateTime('NOW + 1 day');


    }



    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
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
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Transport
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set dateenlevement
     *
     * @param \DateTime $dateenlevement
     *
     * @return Transport
     */
    public function setDateenlevement($dateenlevement)
    {
        $this->dateenlevement = $dateenlevement;

        return $this;
    }

    /**
     * Get dateenlevement
     *
     * @return \DateTime
     */
    public function getDateenlevement()
    {
        return $this->dateenlevement;
    }

    /**
     * Set datelivraison
     *
     * @param \DateTime $datelivraison
     *
     * @return Transport
     */
    public function setDatelivraison($datelivraison)
    {
        $this->datelivraison = $datelivraison;

        return $this;
    }

    /**
     * Get datelivraison
     *
     * @return \DateTime
     */
    public function getDatelivraison()
    {
        return $this->datelivraison;
    }

    /**
     * Set remarque
     *
     * @param string $remarque
     *
     * @return Transport
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;

        return $this;
    }

    /**
     * Get remarque
     *
     * @return string
     */
    public function getRemarque()
    {
        return $this->remarque;
    }

    /**
     * Set operation
     *
     * @param string $operation
     *
     * @return Transport
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set effectue
     *
     * @param boolean $effectue
     *
     * @return Transport
     */
    public function setEffectue($effectue)
    {
        $this->effectue = $effectue;

        return $this;
    }

    /**
     * Get effectue
     *
     * @return boolean
     */
    public function getEffectue()
    {
        return $this->effectue;
    }

    /**
     * Set annule
     *
     * @param boolean $annule
     *
     * @return Transport
     */
    public function setAnnule($annule)
    {
        $this->annule = $annule;

        return $this;
    }

    /**
     * Get annule
     *
     * @return boolean
     */
    public function getAnnule()
    {
        return $this->annule;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Transport
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Set transporteur
     *
     * @param \PB\TransportBundle\Entity\Transporteur $transporteur
     *
     * @return Transport
     */
    public function setTransporteur(\PB\TransportBundle\Entity\Transporteur $transporteur = null)
    {
        $this->transporteur = $transporteur;

        return $this;
    }

    /**
     * Get transporteur
     *
     * @return \PB\TransportBundle\Entity\Transporteur
     */
    public function getTransporteur()
    {
        return $this->transporteur;
    }

    /**
     * Set adresseFrom
     *
     * @param \PB\TransportBundle\Entity\Adresse $adresseFrom
     *
     * @return Transport
     */
    public function setAdresseFrom(\PB\TransportBundle\Entity\Adresse $adresseFrom = null)
    {
        $this->adresseFrom = $adresseFrom;

        return $this;
    }

    /**
     * Get adresseFrom
     *
     * @return \PB\TransportBundle\Entity\Adresse
     */
    public function getAdresseFrom()
    {
        return $this->adresseFrom;
    }

    /**
     * Set adresseTo
     *
     * @param \PB\TransportBundle\Entity\Adresse $adresseTo
     *
     * @return Transport
     */
    public function setAdresseTo(\PB\TransportBundle\Entity\Adresse $adresseTo = null)
    {
        $this->adresseTo = $adresseTo;

        return $this;
    }

    /**
     * Get adresseTo
     *
     * @return \PB\TransportBundle\Entity\Adresse
     */
    public function getAdresseTo()
    {
        return $this->adresseTo;
    }

    /**
     * Set contactFrom
     *
     * @param \PB\TransportBundle\Entity\Contact $contactFrom
     *
     * @return Transport
     */
    public function setContactFrom(\PB\TransportBundle\Entity\Contact $contactFrom = null)
    {
        $this->contactFrom = $contactFrom;

        return $this;
    }

    /**
     * Get contactFrom
     *
     * @return \PB\TransportBundle\Entity\Contact
     */
    public function getContactFrom()
    {
        return $this->contactFrom;
    }

    /**
     * Set contactTo
     *
     * @param \PB\TransportBundle\Entity\Contact $contactTo
     *
     * @return Transport
     */
    public function setContactTo(\PB\TransportBundle\Entity\Contact $contactTo = null)
    {
        $this->contactTo = $contactTo;

        return $this;
    }

    /**
     * Get contactTo
     *
     * @return \PB\TransportBundle\Entity\Contact
     */
    public function getContactTo()
    {
        return $this->contactTo;
    }
}
