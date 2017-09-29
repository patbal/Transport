<?php

namespace PB\CamionBundle\Controller;

use PB\CamionBundle\Form\CamionAddType;
use PB\CamionBundle\Form\CamionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PB\CamionBundle\Entity\Camion;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CamionController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addCamionAction(Request $request)
    {
        $camion = new Camion();
        $form = $this -> get('form.factory')->create( CamionAddType::class, $camion);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $camion->setCreePar($this->getUser()->getUsername());
            $em->persist($camion);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Demande de location enregistrée');

            return $this->redirectToRoute('pb_camion_homepage');
        }

        return $this->render('PBCamionBundle:Camion:addCamion.html.twig', array('form' => $form->createView()));
    }

    Public function viewCamionAction(Camion $camion, $id)
    {
        if (null === $camion) {
            throw new NotFoundHttpException("Cette demande de location n'existe pas !");
        }

        return $this->render('PBCamionBundle:Camion:viewCamion.html.twig', array('camion' => $camion));
    }

}