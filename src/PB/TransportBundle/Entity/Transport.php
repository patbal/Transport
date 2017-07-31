<?php

namespace PB\TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PB\TransportBundle\Entity\Adresse;
use PB\TransportBundle\Entity\Contact;
use PB\TransportBundle\Entity\Transporteur;
use PB\TransportBundle\Entity\TypeVehicule;

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
     * @var \Time
     *
     * @ORM\Column(name="heureenlevement", type="time", nullable=true)
     */
    private $heureEnlevement;

    /**
     * @var \Time
     *
     * @ORM\Column(name="heureelivraison", type="time", nullable=true)
     */
    private $heureLivraison;

    /**
     * @var \datetime
     *
     * @ORM\Column(name="datelivraison", type="datetime")
     */
     
    private $datelivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="text", nullable=true)
     */
    private $remarque;

    /**
     * @var string
     *
     * @ORM\Column(name="operation", type="string", length=255, nullable=true)
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
     * @var bool
     *
     * @ORM\Column(name="facturerecue", type="boolean")
     */
    
    private $facturerecue;
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
     * @var int
     *
     *@ORM\Column(name="mplancher", type="integer", nullable=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $mplancher; 

    /**
     * @var string
     *
     *@ORM\Column(name="nbpalettes", type="string", length=255, nullable=true)
     */
    private $nbPalettes;

     /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\TypeVehicule")
     * @ORM\JoinColumn(nullable=true)
     */
    private $vehicule;

    /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\TypeTransport")
     * @ORM\JoinColumn(nullable=true)
     */
    private $typeTr;

    /**
     * @var decimal
     *
     * @ORM\Column(name="montantfacture", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $montantfacture;

     /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\Factures", inversedBy="transports")
     * @ORM\JoinColumn(nullable=true)
    */
    private $facture;


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
        $this->effectue = false;
        $this->annule = false;
        $this->facturerecue = false;


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
     * @param Transporteur $transporteur
     *
     * @return Transport
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
     * Set adresseFrom
     *
     * @param Adresse $adresseFrom
     *
     * @return Transport
     */
    public function setAdresseFrom(Adresse $adresseFrom = null)
    {
        $this->adresseFrom = $adresseFrom;

        return $this;
    }

    /**
     * Get adresseFrom
     *
     * @return Adresse
     */
    public function getAdresseFrom()
    {
        return $this->adresseFrom;
    }

    /**
     * Set adresseTo
     *
     * @param Adresse $adresseTo
     *
     * @return Transport
     */
    public function setAdresseTo(Adresse $adresseTo = null)
    {
        $this->adresseTo = $adresseTo;

        return $this;
    }

    /**
     * Get adresseTo
     *
     * @return Adresse
     */
    public function getAdresseTo()
    {
        return $this->adresseTo;
    }

    /**
     * Set contactFrom
     *
     * @param Contact $contactFrom
     *
     * @return Transport
     */
    public function setContactFrom(Contact $contactFrom = null)
    {
        $this->contactFrom = $contactFrom;

        return $this;
    }

    /**
     * Get contactFrom
     *
     * @return Contact
     */
    public function getContactFrom()
    {
        return $this->contactFrom;
    }

    /**
     * Set contactTo
     *
     * @param Contact $contactTo
     *
     * @return Transport
     */
    public function setContactTo(Contact $contactTo = null)
    {
        $this->contactTo = $contactTo;

        return $this;
    }

    /**
     * Get contactTo
     *
     * @return Contact
     */
    public function getContactTo()
    {
        return $this->contactTo;
    }

    /**
     * Set mplancher
     *
     * @param integer $mplancher
     *
     * @return Transport
     */
    public function setMplancher($mplancher)
    {
        $this->mplancher = $mplancher;

        return $this;
    }

    /**
     * Get mplancher
     *
     * @return integer
     */
    public function getMplancher()
    {
        return $this->mplancher;
    }

    /**
     * Set nbPalettes
     *
     * @param integer $nbPalettes
     *
     * @return Transport
     */
    public function setNbPalettes($nbPalettes)
    {
        $this->nbPalettes = $nbPalettes;

        return $this;
    }

    /**
     * Get nbPalettes
     *
     * @return integer
     */
    public function getNbPalettes()
    {
        return $this->nbPalettes;
    }

    /**
     * Set vehicule
     *
     * @param TypeVehicule $vehicule
     *
     * @return Transport
     */
    public function setVehicule(TypeVehicule $vehicule = null)
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    /**
     * Get vehicule
     *
     * @return TypeVehicule
     */
    public function getVehicule()
    {
        return $this->vehicule;
    }

    /**
     * Set typeTr
     *
     * @param \PB\TransportBundle\Entity\TypeTransport $typeTr
     *
     * @return Transport
     */
    public function setTypeTr(\PB\TransportBundle\Entity\TypeTransport $typeTr = null)
    {
        $this->typeTr = $typeTr;

        return $this;
    }

    /**
     * Get typeTr
     *
     * @return \PB\TransportBundle\Entity\TypeTransport
     */
    public function getTypeTr()
    {
        return $this->typeTr;
    }

    /**
     * Set heureEnlevement
     *
     * @param \DateTime $heureEnlevement
     *
     * @return Transport
     */
    public function setHeureEnlevement($heureEnlevement)
    {
        $this->heureEnlevement = $heureEnlevement;

        return $this;
    }

    /**
     * Get heureEnlevement
     *
     * @return \DateTime
     */
    public function getHeureEnlevement()
    {
        return $this->heureEnlevement;
    }

    /**
     * Set heureLivraison
     *
     * @param \DateTime $heureLivraison
     *
     * @return Transport
     */
    public function setHeureLivraison($heureLivraison)
    {
        $this->heureLivraison = $heureLivraison;

        return $this;
    }

    /**
     * Get heureLivraison
     *
     * @return \DateTime
     */
    public function getHeureLivraison()
    {
        return $this->heureLivraison;
    }

    /**
     * Set montantfacture
     *
     * @param string $montantfacture
     *
     * @return Transport
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
     * Set facture
     *
     * @param \PB\TransportBundle\Entity\Factures $facture
     *
     * @return Transport
     */
    public function setFacture(\PB\TransportBundle\Entity\Factures $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \PB\TransportBundle\Entity\Factures
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set facturerecue
     *
     * @param boolean $facturerecue
     *
     * @return Transport
     */
    public function setFacturerecue($facturerecue)
    {
        $this->facturerecue = $facturerecue;

        return $this;
    }

    /**
     * Get facturerecue
     *
     * @return boolean
     */
    public function getFacturerecue()
    {
        return $this->facturerecue;
    }
}
