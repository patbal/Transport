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

class TransportController extends Controller
{
    public function indexAction($page)
    {
	  
		if ($page < 1) {
		throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    	}
    
	    //on récupère le nombre de transports affichés par page
	    $nbPerPage = $this -> container -> getParameter('nb_per_page');

	    // On récupère l'objet Paginator
	    $listTransports = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('PBTransportBundle:Transport')
	      ->getTransports($page, $nbPerPage)
	    ;
	    // On calcule le nombre total de pages grâce au count($listTransports) qui retourne le nombre total de transport
	    $nbPages = ceil(count($listTransports) / $nbPerPage);
	    // Si la page n'existe pas, on retourne une 404
	    if ($page > $nbPages) {
	      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
	    }
	    // On donne toutes les informations nécessaires à la vue
	    return $this->render('PBTransportBundle:Transport:index.html.twig', array(
	      'listTransports' => $listTransports,
	      'nbPages'     => $nbPages,
	      'page'        => $page,
	    ));

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAdresseAction(Request $request)
    {
        $adresse = new Adresse();
        $form = $this -> get('form.factory')->create(AdresseType::class, $adresse);
        $em = $this->getDoctrine()->getManager();

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em -> persist($adresse);
            $em -> flush();

            $request->getSession()->getFlashBag()->add('notice', 'Ajout d\'adresse effectuée');

            return $this->redirectToRoute("pb_transport_homepage");
        }

        return $this->render("PBTransportBundle:Transport:editAdresse.html.twig", array('form' => $form->createView(), 'titre' => "Création d'adresse", 'boutonDel' => false));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAdressesAction()
    {
    	$listadresses = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('PBTransportBundle:Adresse')
	      ->getAdresses();
    	
    	return $this->render('PBTransportBundle:Transport:viewAdresses.html.twig', array(
    		'adresses'	=> $listadresses));
    }


    /**
     * @param Adresse $adresse
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAdresseAction(Adresse $adresse, $id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$adresse = $em->getRepository('PBTransportBundle:Adresse')->find($id);
		$form = $this -> get('form.factory')->create(AdresseType::class, $adresse);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

			$em -> persist($adresse);
			$em -> flush();

			$request->getSession()->getFlashBag()->add('notice', 'Modification d\'adresse effectuée');

			return $this->redirectToRoute('pb_transport_homepage', array(
				'id' => $adresse->getId())
			);
		}

		return $this->render('PBTransportBundle:Transport:editAdresse.html.twig', ['adresse' => $adresse, 'form' => $form->createView(), 'titre' => "Modification d'adresse", 'boutonDel' => true]);
    }

    /**
     * @param Adresse $adresse
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAdresseAction(Adresse $adresse, $id, Request $request)
    {
        if (null === $adresse)
        {
            throw new NotFoundHttpException("adresse inexistante en base de donnée");
        }

        $em = $this->getDoctrine()->getManager();
        $em -> remove($adresse);
        $em -> flush();

        $request -> getSession() -> getFlashbag() -> add('alert', 'Adresse Supprimée');
        return $this -> redirectToRoute('pb_transport_homepage');
    }

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



    // *************************************************************************************************
    // **************************************** TRANSPORTS *********************************************
    // *************************************************************************************************

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addTransportAction(Request $request)
	{
		$transport = new Transport();
		$form = $this -> get('form.factory')->create(TransportBriefType::class, $transport);//type hérité de transport, avec suppression de champs

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em -> persist($transport);
			$em -> flush();

			// $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

			return $this->redirectToRoute('pb_transport_adddetailtransport', array(
				'id' => $transport->getId())
			);
		}

		return $this->render('PBTransportBundle:Transport:addTransport.html.twig', array('form' => $form->createView()));
	}

    /**
     * @param Transport $transport
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addDetailTransportAction(Transport $transport, $id, Request $request)
	{
		$form = $this -> get('form.factory')->create(DetailTransportType::class, $transport); //type hérité de transport, avec suppression de champs

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em -> persist($transport);
			$em -> flush();

			$request->getSession()->getFlashBag()->add('notice', 'Transport request successfull');

			return $this->redirectToRoute('pb_transport_viewtransport', array(
				'id' => $transport->getId())
			);
		}

		return $this->render('PBTransportBundle:Transport:addDetailTransport.html.twig', array('transport' => $transport, 'form' => $form->createView()));

	}

    /**
     * @param Transport $transport
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteTransportAction(Transport $transport, $id, Request $request)
	{
		if (null === $transport)
		{
			throw new NotFoundHttpException("Ce transport n'existe pas.");
		}

		$em = $this->getDoctrine()->getManager();
		$em -> remove($transport);
		$request->getSession()->getFlashBag()->add('alert', 'Transport n° '.$transport->getNumber().$transport->getId().' supprimé.');
		$em -> flush();

		return $this -> redirectToRoute('pb_transport_homepage');
	}

    /**
     * @param Transport $transport
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editTransportAction(Transport $transport, $id, Request $request)
	{
		if (null === $transport)
		{
			throw new NotFoundHttpException("Ce transport n'existe pas.");
		}

		$form = $this -> get('form.factory')->create(TransportEditType::class, $transport); 
		$em = $this -> getDoctrine() -> getManager();

		if ($request->isMethod('POST') && $form -> handleRequest($request)->isValid())
		{
			$em -> persist($transport);
			$request -> getSession() -> getFlashBag() -> add('notice', 'Transport n° '.$transport -> getNumber().$id.' modifié');
			$em -> flush();
			return $this -> redirectToRoute('pb_transport_viewtransport', array('id' => $transport->getId()));
		}

		return $this -> render('PBTransportBundle:Transport:editTransport.html.twig', array("transport" => $transport, 'form' => $form -> createView()));


	}

    /**
     * @param Transport $transport
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewTransportAction(Transport $transport, $id)
    {
        if (null === $transport) {
            throw new NotFoundHttpException("Cette demande de transport n'existe pas !");
        }

        return $this->render('PBTransportBundle:Transport:viewTransport.html.twig', array(
            'transport'	=> $transport));
    }

    // *************************************************************************************************
    // **************************************** FACTURES ***********************************************
    // *************************************************************************************************

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addFactureAction(Request $request)
    {
        $facture = new Factures();
        $form = $this -> get('form.factory')->create(FacturesType::class, $facture);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em -> persist($facture);
            $em -> flush();

            $request->getSession()->getFlashBag()->add('notice', 'Facture bien enregistrée.');

            return $this->redirectToRoute('pb_transport_viewfactures');
        }

        return $this->render('PBTransportBundle:Transport:editFacture.html.twig', array('facture'=>$facture, 'form' => $form->createView(), 'titre'=>'Entrée d\'une facture', 'boutonDel' => true));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewFacturesAction($page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }

        $nbPerPage = $this -> container -> getParameter('nb_per_page');

        $listFactures = $this->getDoctrine()
            ->getManager()
            ->getRepository('PBTransportBundle:Factures')
            ->getFactures($page, $nbPerPage)
        ;
        $nbPages = ceil(count($listFactures) / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        return $this->render('PBTransportBundle:Transport:viewFactures.html.twig', array(
            'listFactures' => $listFactures,
            'nbPages'     => $nbPages,
            'page'        => $page,
        ));
    }

    public function viewFactureAction(Factures $facture, $id)
    {
        if (null === $facture) {
            throw new NotFoundHttpException('Facture inexistante.');
        }

        $transports = $this -> getDoctrine()->getRepository('PBTransportBundle:Transport')->findByfacture($facture->getId());

        return $this -> render('PBTransportBundle:Transport:viewFacture.html.twig', array('facture'=>$facture, 'transports'=>$transports));
    }


}
