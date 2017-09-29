<?php

namespace PB\CamionBundle\Controller;

use PB\CamionBundle\Form\CamionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PB\CamionBundle\Entity\Camion;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CamionController extends Controller
{

    public function indexAction(REQUEST $request)
    {
        //on récupère le nombre de camions affichés par page
        $nbPerPage = $this -> container -> getParameter('nb_per_page');

        // On récupère la query
        $listeCamions = $this->getDoctrine()
            ->getManager()
            ->getRepository('PBCamionBundle:Camion')
            ->getListeCamions()
        ;

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($listeCamions, $request->query->getInt('page', 1),$nbPerPage);

        // On donne toutes les informations nécessaires à la vue
        return $this->render('PBCamionBundle:Camion:index.html.twig', array(
            'listeCamions' => $pagination
        ));

    }

    public function addCamionAction(Request $request)
    {
        $camion = new Camion();
        $form = $this -> get('form.factory')->create( CamionType::class, $camion);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $camion->setCreePar($this->getUser()->getUsername());
            $em->persist($camion);
            $em->flush();

            return $this->redirectToRoute('pb_camion_homepage');
        }

        return $this->render('PBCamionBundle:Camion:addCamion.html.twig', array('form' => $form->createView()));
    }

}
