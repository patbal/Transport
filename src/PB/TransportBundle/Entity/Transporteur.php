<?php

namespace PB\TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PB\TransportBundle\Entity\Contact;

/**
 * Transporteur
 *
 * @ORM\Table(name="tretransporteur")
 * @ORM\Entity(repositoryClass="PB\TransportBundle\Repository\TransporteurRepository")
 */
class Transporteur
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
     * @ORM\Column(name="adresse_rue", type="string", length=255, nullable=true)
     */
    private $adresseRue;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_rue2", type="string", length=255, nullable=true)
     */
    private $adresseRue2;

    /**
     * @var int
     *
     * @ORM\Column(name="codepostal", type="integer", nullable=true)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="PB\TransportBundle\Entity\Contact", mappedBy="transporteur")
     *
     */
    private $contacts; 



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this -> email = 'adressnonrenseignee@ull.com';
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Transporteur
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
     * Set adresseRue
     *
     * @param string $adresseRue
     *
     * @return Transporteur
     */
    public function setAdresseRue($adresseRue)
    {
        $this->adresseRue = $adresseRue;

        return $this;
    }

    /**
     * Get adresseRue
     *
     * @return string
     */
    public function getAdresseRue()
    {
        return $this->adresseRue;
    }

    /**
     * Set adresseRue2
     *
     * @param string $adresseRue2
     *
     * @return Transporteur
     */
    public function setAdresseRue2($adresseRue2)
    {
        $this->adresseRue2 = $adresseRue2;

        return $this;
    }

    /**
     * Get adresseRue2
     *
     * @return string
     */
    public function getAdresseRue2()
    {
        return $this->adresseRue2;
    }

    /**
     * Set codepostal
     *
     * @param integer $codepostal
     *
     * @return Transporteur
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal
     *
     * @return integer
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Transporteur
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Transporteur
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
     * Add contact
     *
     * @param \PB\TransportBundle\Entity\Contact $contact
     *
     * @return Transporteur
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
        return $this;
    }

    /**
     * Remove contact
     *
     * @param \PB\TransportBundle\Entity\Contact $contact
     */
    public function removeContact(Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Transporteur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

/*
    public function compareContacts(Transporteur $newTransporteur)
    {
        $oldContacts = $this->getContacts();
        $newContacts = $newTransporteur->getContacts();
        $em = $this->getEntityManager();
        foreach($newContacts->getIterator() as $newContact);
        {
            foreach ($oldContacts->getIterator() as $oldContact)
            {
                if (!$newContacts->contains($oldContact)) {
                    $newContact->setTransporteur(null);
                    $em->persist($newContact);
                }
            }
            $newContact->setTransporteur($newTransporteur);
            $em -> persist($newTransporteur);
        }
        return $this;
    }*/
}
