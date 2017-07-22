<?php
// src/PB/TransportBundle/DataFixtures/ORM/LoadTransporteurs.php

namespace PB\TransportBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PB\TransportBundle\Entity\Contact;
use PB\TransportBundle\Entity\Transporteur;
use PB\TransportBundle\Entity\Adresse;

class LoadCategory implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de contact à ajouter
    $names = array(
      'Florence', 'Franck CARRARO', 'Elsa CAMBIER', 'Laurent SANCHEZ', 'Emmanuel GAILLARD', 'David DILLIES', 'Patrick LEVEL', 'Thierry', 'Ludo', 'Alexandre BREME', 'Christophe POULIN', 'Damien THEVIN', 'Franck CARRARO', 'Philippe Mereau', 'Tony', 'Ludovic', 'Jean Pierre', 'Ariel Moulin', 'Sébastien Elmon', 'Yannick DUHAU', 'Stéphane Delpech', 'Hervé LEGAD', 'Sébastien', 'Aurélien', 'Xavier', 'Pascal MAS', 'Pierre JACQUIN', 'Arno VEYRAT', 'Julien', 'DAVID VERDE', 'Samantha', 'CAROLE CHINA', 'CYRIL', 'jean phi', 'Charles Cheveux', 'Elsa CAMBIER ', 'simon', 'Dominique MAUREL', 'Thomas DUPEYRON', 'Alain Gabel', 'Cyril SEYNE', 'Florent', 'Alexandre LY', 'MR VIALA', 'Jean Marc PAIN', 'NASSIMO', 'Christophe DIGNE', 'Benjamin', 'Renaud', 'Alexandre', 'Axel', 'Matthieu', 'Sebastien ELMON', 'Cédric', 'Serge Falga', 'Cinthia', 'Serge ', 'Belgique', 'JEAN CHARLES', 'NICOLAS', 'NATHALIE', 'sebastien', 'FRANCOIS', 'DAVID', 'Alexis', 'Hervé', 'Géraldine CORRADO', 'PAUL ANDRIEU', 'ANTHONY', 'Stéphane', 'Emilien', 'Alain', 'Cyrille DE CASTRO', 'Jean ', 'Stéphane PLAZIAT', 'Laurent MARQUIS'
    );

    // $adresse=new Adresse();
    // $transporteur = new Transporteur()

    foreach ($names as $name) {
      // On crée le contact
      $contact = new Contact();
      // $contact->setAdresse($adresse);
      $contact->setNom($name);
      // $contact->setTransporteur($transporteur);

      // On le persiste
      $manager->persist($contact);
    }

    // On déclenche l'enregistrement de tous les contacts
    $manager->flush();
  }
}