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

class ContactController extends Controller
{

    // *************************************************************************************************
    // **************************************** CONTACTS ***********************************************
    // *************************************************************************************************

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addContactAction(Request $request)
    {
    	$contact = new Contact();
		$form = $this -> get('form.factory')->create(ContactType::class, $contact);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em -> persist($contact);
			$em -> flush();

			$request->getSession()->getFlashBag()->add('notice', 'Contact ajouté');

			return $this->redirectToRoute('pb_transport_homepage');
		}

		return $this->render('PBTransportBundle:Transport:editContact.html.twig', array('form' => $form->createView(), 'titre' => "Ajout de contact", 'boutonDel' => false));
    }

    /**
     * @param Contact $contact
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewContactAction(Contact $contact, $id)
    {
    	if (null === $contact) {
      		throw new NotFoundHttpException("Ce contact n'existe pas !");
    	}

    	return $this->render('PBTransportBundle:Transport:viewContact.html.twig', array(
    		'contact'	=> $contact));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewContactsAction()
    {
        $listContacts = $this -> getDoctrine()->getRepository('PBTransportBundle:Contact')->getContacts();
        return $this -> render('PBTransportBundle:Transport:viewContacts.html.twig', array('contacts' => $listContacts));
    }

    /**
     * @param Contact $contact
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editContactAction(Contact $contact, $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this -> get('form.factory')->create(ContactType::class, $contact);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->persist($contact);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Modification de contact effectuée');

            return $this->redirectToRoute('pb_transport_viewcontacts');
        }

        return $this->render('PBTransportBundle:Transport:editContact.html.twig', ['contact' => $contact, 'form' => $form->createView(), 'titre' => "Modification de contact", 'boutonDel' => true]);
    }

    /**
     * @param Contact $contact
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteContactAction(Contact $contact, $id, Request $request)
    {
        if (null === $contact)
        {
            throw new NotFoundHttpException("contact inexistant en base de donnée");
        }

        $em = $this->getDoctrine()->getManager();
        $em -> remove($contact);
        $em -> flush();

        $request -> getSession() -> getFlashbag() -> add('alert', 'Contact Supprimé');
        return $this -> redirectToRoute('pb_transport_homepage');
    }


}
