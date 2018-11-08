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
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;

class TransportController extends Controller
{

    const NPP = 20;

    /**
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(REQUEST $request)
    {

	    //on récupère le nombre de transports affichés par page
        //$nbPerPage = $this -> getParameter('nombre_par_page');
        $nbPerPage = 20;

	    // On récupère la query
	    $listTransports = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('PBTransportBundle:Transport')
	      ->getTransports()
	    ;

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $listTransports, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,$nbPerPage);

	    // On donne toutes les informations nécessaires à la vue
	    return $this->render('PBTransportBundle:Transport:index.html.twig', array(
	      'listTransports' => $pagination,
	    ));

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
		$form = $this -> get('form.factory')->create( TransportBriefType::class, $transport);//type hérité de transport, avec suppression de champs

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
            $transport -> setCreepar($this->getUser()->getUsername());
			$em -> persist($transport);
			$em -> flush();

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

    /**
     * @param Transport $transport
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendMailAction(Transport $transport, $id, Request $request)
    {
        $trans = (new \Swift_SmtpTransport($this -> container -> getParameter('mailer_host'), $this -> container -> getParameter('mailer_port'), "TLS"))
            ->setUsername($this -> container -> getParameter('mailer_user'))
            ->setPassword($this -> container ->getParameter('mailer_password'));
        $mailer = new \Swift_Mailer($trans);
        $mailFrom = $this->getUser()->getEmail();
        $nomFrom = $this->getUser()->getPrenom().' '.$this->getUser()->getNom();
        $transporteur = $transport->getTransporteur();
        $mailTo = $transporteur -> getEmail();

        $message = (new \Swift_Message('Demande de transport'))
            //->setFrom('DushowTransportsDaemon@dushow.com')
            ->setFrom('dushow-toulouse-transport-daemon@dushow.com')
            ->setTo($mailTo)
            ->setReplyTo([$mailFrom => $nomFrom])
            ->setBcc($mailFrom)
            ->setBody(
                $this->renderView('PBTransportBundle:Mails:sendMail.html.twig', array(
                        'transport'	=> $transport, 'nomFrom'=>$nomFrom)
                ),'text/html')
            ->addPart(
                $this->renderView(
                    'PBTransportBundle:Mails:sendMail.txt.twig',
                    array('transport'	=> $transport, 'nomFrom'=>$nomFrom)
                ),
                'text/plain'
            );


        $mailer->send($message);

        $transport -> setMailSentDate(new \DateTime());
        $transport -> setMailSent(true);
        $em = $this ->getDoctrine()->getManager();
        $em -> persist($transport);
        $em -> flush();

        $request -> getSession() -> getFlashBag() -> add('notice', 'Mail de demande de transport envoyé à '.$mailTo.' - vous en recevrez une copie');

        return $this->redirectToRoute('pb_transport_viewtransport', array('id'=>$transport->getId()));
    }

    /**
     * @param Transport $transport
     * @param $id
     * @return string
     */
    public function viewMailAction(Transport $transport, $id)
    {
        $nomFrom = $this->getUser()->getPrenom().' '.$this->getUser()->getNom();
        return $this->render('PBTransportBundle:Mails:viewMail.html.twig', array(
                'transport'	=> $transport, 'nomFrom'=>$nomFrom));
    }



}
