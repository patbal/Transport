<?php

namespace PB\TransportBundle\Controller;

use PB\TransportBundle\Entity\Factures;
use PB\TransportBundle\Entity\Transport;
use PB\TransportBundle\Entity\Adresse;
use PB\TransportBundle\Entity\Contact;
use PB\TransportBundle\Entity\Transporteur;
use Doctrine\Common\Collections\ArrayCollection;
use PB\TransportBundle\Form\DetailTransportType;
use PB\TransportBundle\Form\FacturesType;
use PB\TransportBundle\Form\TransportBriefType;
use PB\TransportBundle\Form\TransportEditType;
use PB\TransportBundle\Form\AdresseType;
use PB\TransportBundle\Form\ContactType;
use PB\TransportBundle\Form\TransporteurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;

class TransporteurController extends Controller
{

    // *************************************************************************************************
    // **************************************** TRANSPORTEURS ******************************************
    // *************************************************************************************************

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addTransporteurAction(Request $request)
    {
        $transporteur = new Transporteur();
        $form = $this -> get('form.factory')->create(TransporteurType::class, $transporteur);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($transporteur->getContacts() as $contact) {
                $contact->setTransporteur($transporteur);
                $em->persist($contact);
            }

            $em -> persist($transporteur);
            $em -> flush();

            $request->getSession()->getFlashBag()->add('notice', 'Transporteur ajouté');

            return $this->redirectToRoute('pb_transport_viewtransporteurs');
        }

        return $this->render('PBTransportBundle:Transport:editTransporteur.html.twig', array('form' => $form->createView(), 'titre' => "Ajout de Transporteur", 'boutonDel' => false));
    }

    /**
     * @param Transporteur $transporteur
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewTransporteurAction(Transporteur $transporteur, $id)
    {
        if (null === $transporteur) {
            throw new NotFoundHttpException("Ce transporteur n'existe pas !");
        }

        return $this->render('PBTransportBundle:Transport:viewTransporteur.html.twig', array(
            'transporteur'	=> $transporteur));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewTransporteursAction()
    {
        $listTransporteurs = $this -> getDoctrine()->getRepository('PBTransportBundle:Transporteur')->getTransporteurs();
        return $this -> render('PBTransportBundle:Transport:viewTransporteurs.html.twig', array('transporteurs' => $listTransporteurs));
    }


    /**
     * @param Transporteur $transporteur
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editTransporteurAction(Transporteur $transporteur, $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this -> get('form.factory')->create(TransporteurType::class, $transporteur);


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // On boucle sur l'entité originale pour en supprimer les contacts Transporteur qui ne sont pas présents dans la nouvelle...
            $oldContacts = $em->getRepository(Contact::class)->findBytransporteur($transporteur->getId());
            foreach ($oldContacts as $oldContact) {
                if (!$transporteur->getContacts()->contains($oldContact)){
                    $oldContact->setTransporteur(null);
                    $em->persist($oldContact);
                }
            }

            // puis on boucle sur la nouvelle pour lui injecter les contacts sélectionnés
            foreach ($transporteur->getContacts() as $contact) {
                $contact->setTransporteur($transporteur);
                $em->persist($contact);
            }


            $em->persist($transporteur);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Modification de transporteur effectuée');

            return $this->redirectToRoute('pb_transport_viewtransporteurs');
        }

        return $this->render('PBTransportBundle:Transport:editTransporteur.html.twig', ['transporteur' => $transporteur, 'form' => $form->createView(), 'titre' => "Modification de transporteur", 'boutonDel' => true]);
    }

    /**
     * @param Transporteur $transporteur
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteTransporteurAction(Transporteur $transporteur, $id, Request $request)
    {
        if (null === $transporteur)
        {
            throw new NotFoundHttpException("transporteur inexistant en base de donnée");
        }

        $em = $this->getDoctrine()->getManager();
        $em -> remove($transporteur);
        $em -> flush();

        $request -> getSession() -> getFlashbag() -> add('alert', 'Transporteur Supprimé');
        return $this -> redirectToRoute('pb_transport_homepage');
    }

}
