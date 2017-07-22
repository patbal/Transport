<?php

namespace PB\TransportBundle\Controller;

use PB\TransportBundle\Entity\Transport;
use PB\TransportBundle\Form\TransportType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TransportController extends Controller
{
    public function indexAction($page)
    {

    	if ($page == "")
    	{
    		$page = 1;
    	}
	  
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
    // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
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

    public function viewAction(Transport $transport, $id)
    {
    	if (null === $transport) {
      		throw new NotFoundHttpException("Cette demande de transport n'existe pas !");
    	}

    	return $this->render('PBTransportBundle:Transport:viewTransport.html.twig', array(
    		'transport'	=> $transport));
    }

	public function addAction(Request $request)
	{
		$transport = new Transport();
		$form = $this -> get('form.factory')->create(TransportType::class, $transport);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em -> persist($transport);
			$em -> flush();

			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

			return $this->redirectToRoute('pb_transport_viewtransport', array(
				'id' => $transport->getId())
			);
		}

		return $this->render('PBTransportBundle:Transport:addTransport.html.twig', array('form' => $form->createView()));
	}

}
