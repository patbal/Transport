<?php

namespace PB\TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="trecontact")
 * @ORM\Entity(repositoryClass="PB\TransportBundle\Repository\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\Adresse", inversedBy="contacts")
     * @ORM\JoinColumn(nullable=true))
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity="PB\TransportBundle\Entity\Transporteur", inversedBy="contacts")
     * @ORM\JoinColumn(nullable=true))
     */
    private $transporteur;



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
     * Set nom
     *
     * @param string $nom
     *
     * @return Contact
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set adresse
     *
     * @param \PB\TransportBundle\Entity\Adresse $adresse
     *
     * @return Contact
     */
    public function setAdresse(\PB\TransportBundle\Entity\Adresse $adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return \PB\TransportBundle\Entity\Adresse
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set transporteur
     *
     * @param \PB\TransportBundle\Entity\Transporteur $transporteur
     *
     * @return Contact
     */
    public function setTransporteur(\PB\TransportBundle\Entity\Transporteur $transporteur)
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
}
