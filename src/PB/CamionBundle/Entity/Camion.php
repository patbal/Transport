<?php

namespace PB\CamionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Camion
 *
 * @ORM\Table(name="gescam_camion")
 * @ORM\Entity(repositoryClass="PB\CamionBundle\Repository\CamionRepository")
 */
class Camion
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
     * @ORM\Column(name="dateEnlevement", type="datetime")
     */
    private $dateEnlevement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRetour", type="datetime", nullable=true)
     */
    private $dateRetour;

    /**
     * @var string
     *
     * @ORM\Column(name="operation", type="text", nullable=true)
     */
    private $operation;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="text", nullable=true)
     */
    private $remarque;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255)
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="PB\CamionBundle\Entity\Loueur")
     */
    private $loueur;

    /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\Contact")
     */
    private $contactFrom;

    /**
     * @ORM\ManyToOne(targetEntity="PB\CamionBundle\Entity\TypeVehicule")
     */
    private $vehicule;

    /**
     * @var bool
     *
     * @ORM\Column(name="hayon", type="boolean", nullable=false)
     */
    private $avecHayon;

    /**
     * @var bool
     *
     * @ORM\Column(name="mailsent", type="boolean", nullable=true)
     */
    private $mailSent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mailsentdate", type="datetime", nullable=true)
     */
    private $mailSentDate;

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
     * @ORM\Column(name="factureRecue", type="boolean")
     */

    private $factureRecue;

    /**
     * @var string
     *
     * @ORM\Column(name="cree_par", type="text", nullable=true)
     */
    private $creePar;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_jours_exploit", type="integer")
     */
    private $nbJoursExploit;

    /**
     * @var \Time
     *
     * @ORM\Column(name="heureEnlevement", type="time", nullable=true)
     */
    private $heureEnlevement;

    /**
     * @var \Time
     *
     * @ORM\Column(name="heureRetour", type="time", nullable=true)
     */
    private $heureRetour;

//************************************************************************
//************************* GETTERS AND SETTERS **************************
//************************************************************************

    /**
     * Camion constructor.
     */
    public function __construct()
    {
        $now = new \DateTime();
        $this->number = 'CR' . $now->format('Y') . $now->format('m') . '-';
        $this->dateCreation = new \DateTime();
        $this->dateEnlevement = new \DateTime();
        $this->heureEnlevement = new \DateTime('14:00');
        $this->dateRetour = new \DateTime('NOW + 2 day');
        $this->heureRetour = new \DateTime('14:00');
        $this->effectue = false;
        $this->annule = false;
        $this->factureRecue = false;
        $this->mailSent = false;
        $this->nbJoursExploit = 1;
        $this->avecHayon = false;
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
     * Set dateEnlevement
     *
     * @param \DateTime $dateEnlevement
     *
     * @return Camion
     */
    public function setDateEnlevement($dateEnlevement)
    {
        $this->dateEnlevement = $dateEnlevement;

        return $this;
    }

    /**
     * Get dateEnlevement
     *
     * @return \DateTime
     */
    public function getDateEnlevement()
    {
        return $this->dateEnlevement;
    }

    /**
     * Set dateRetour
     *
     * @param \DateTime $dateRetour
     *
     * @return Camion
     */
    public function setDateRetour($dateRetour)
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    /**
     * Get dateRetour
     *
     * @return \DateTime
     */
    public function getDateRetour()
    {
        return $this->dateRetour;
    }

    /**
     * Set operation
     *
     * @param string $operation
     *
     * @return Camion
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
     * Set remarque
     *
     * @param string $remarque
     *
     * @return Camion
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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Camion
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Camion
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
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
     * Set loueur
     *
     * @param \PB\CamionBundle\Entity\Loueur $loueur
     *
     * @return Camion
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
     * Set contactFrom
     *
     * @param \PB\TransportBundle\Entity\Contact $contactFrom
     *
     * @return Camion
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
     * Set vehicule
     *
     * @param \PB\CamionBundle\Entity\TypeVehicule $vehicule
     *
     * @return Camion
     */
    public function setVehicule(\PB\CamionBundle\Entity\TypeVehicule $vehicule = null)
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    /**
     * Get vehicule
     *
     * @return \PB\CamionBundle\Entity\TypeVehicule
     */
    public function getVehicule()
    {
        return $this->vehicule;
    }

    /**
     * Set avecHayon
     *
     * @param boolean $avecHayon
     *
     * @return Camion
     */
    public function setAvecHayon($avecHayon)
    {
        $this->avecHayon = $avecHayon;

        return $this;
    }

    /**
     * Get avecHayon
     *
     * @return boolean
     */
    public function getAvecHayon()
    {
        return $this->avecHayon;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Camion
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set mailSent
     *
     * @param boolean $mailSent
     *
     * @return Camion
     */
    public function setMailSent($mailSent)
    {
        $this->mailSent = $mailSent;

        return $this;
    }

    /**
     * Get mailSent
     *
     * @return boolean
     */
    public function getMailSent()
    {
        return $this->mailSent;
    }

    /**
     * Set mailSentDate
     *
     * @param \DateTime $mailSentDate
     *
     * @return Camion
     */
    public function setMailSentDate($mailSentDate)
    {
        $this->mailSentDate = $mailSentDate;

        return $this;
    }

    /**
     * Get mailSentDate
     *
     * @return \DateTime
     */
    public function getMailSentDate()
    {
        return $this->mailSentDate;
    }

    /**
     * Set effectue
     *
     * @param boolean $effectue
     *
     * @return Camion
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
     * @return Camion
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
     * Set factureRecue
     *
     * @param boolean $factureRecue
     *
     * @return Camion
     */
    public function setFactureRecue($factureRecue)
    {
        $this->factureRecue = $factureRecue;

        return $this;
    }

    /**
     * Get factureRecue
     *
     * @return boolean
     */
    public function getFactureRecue()
    {
        return $this->factureRecue;
    }

    /**
     * Set creePar
     *
     * @param string $creePar
     *
     * @return Camion
     */
    public function setCreePar($creePar)
    {
        $this->creePar = $creePar;

        return $this;
    }

    /**
     * Get creePar
     *
     * @return string
     */
    public function getCreePar()
    {
        return $this->creePar;
    }

    /**
     * Set nbJoursExploit
     *
     * @param integer $nbJoursExploit
     *
     * @return Camion
     */
    public function setNbJoursExploit($nbJoursExploit)
    {
        $this->nbJoursExploit = $nbJoursExploit;

        return $this;
    }

    /**
     * Get nbJoursExploit
     *
     * @return integer
     */
    public function getNbJoursExploit()
    {
        return $this->nbJoursExploit;
    }

    /**
     * Set heureEnlevement
     *
     * @param \DateTime $heureEnlevement
     *
     * @return Camion
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
     * Set heureRetour
     *
     * @param \DateTime $heureRetour
     *
     * @return Camion
     */
    public function setHeureRetour($heureRetour)
    {
        $this->heureRetour = $heureRetour;

        return $this;
    }

    /**
     * Get heureRetour
     *
     * @return \DateTime
     */
    public function getHeureRetour()
    {
        return $this->heureRetour;
    }
}
