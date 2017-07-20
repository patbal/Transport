<?php

namespace PB\TransportBundle\Controller;

use PB\TransportBundle\Entity\Transport;
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
      // $page = (int)$page;
	  
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
}
