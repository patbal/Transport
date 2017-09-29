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

//************************************************************************
//************************* GETTERS AND SETTERS **************************
//************************************************************************

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
}
