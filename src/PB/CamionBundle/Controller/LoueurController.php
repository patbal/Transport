<?php

namespace PB\CamionBundle\Controller;

use PB\CamionBundle\Form\LoueurType;
use Symfony\Component\HttpFoundation\Request;
use PB\CamionBundle\Entity\Loueur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LoueurController extends Controller
{

    /**
     * @return string
     */
    public function indexLoueurAction(Request $request)
    {
        $nbPerPage = $this -> container -> getParameter('nb_per_page');

        $em = $this->getDoctrine()->getManager();
        $listeLoueurs = $em -> getRepository('PBCamionBundle:Loueur') -> getListeLoueurs();
        $paginator = $this -> get('knp_paginator');
        $pagination = $paginator -> paginate($listeLoueurs, $request->query->getInt('page', 1), $nbPerPage);

        return $this -> render('PBCamionBundle:Loueur:index.html.twig', array('listeLoueurs' => $pagination));
    }


    /**
     * @param Loueur $loueur
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteLoueurAction(Loueur $loueur, $id, Request $request)
    {
        if($loueur === null)
        {
            throw new NotAcceptableHttpException(('Bien tenté, jeune padawan'));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($loueur);
        $request->getSession()->getFlashBag()-> add('danger', 'Loueur "'.$loueur->getNom().'" supprimé');
        $em->flush();

        return $this->redirectToRoute('pb_camion_indexloueur');

    }

    public function editLoueurAction(Loueur $loueur, $id, Request $request)
    {
        if ($loueur === null)
        {
            throw new NotFoundHttpException(('Sans déconner... SANS DECONNER !!!'));
        }

        $form = $this -> get('form.factory')->create(LoueurType::class, $loueur);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($loueur);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le loueur "'.$loueur-> getNom().'" a été modifié');

            return $this->redirectToRoute('pb_camion_viewloueur', array('id'=>$loueur->getId()));
        }

        return $this-> render('@PBCamion/Loueur/edit.html.twig', array('loueur'=>$loueur, 'action'=>'edit', 'form'=>$form -> createView()));
    }

    public function addLoueurAction(Request $request)
    {
        $loueur = new Loueur();

        $form = $this -> get('form.factory')->create(LoueurType::class, $loueur);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($loueur);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le loueur "'.$loueur-> getNom().'" a été créé');

            return $this->redirectToRoute('pb_camion_viewloueur', array('id'=>$loueur->getId()));
        }

        return $this-> render('@PBCamion/Loueur/edit.html.twig', array('loueur'=>$loueur, 'action'=>'add', 'form'=>$form -> createView()));
    }

    public function viewLoueurAction(Loueur $loueur, $id)
    {
        if($loueur === null)
        {
            throw new NotFoundHttpException('Mais arrête d\'essayer de pirater, t\'es une buse...');
        }

        return $this->render('PBCamionBundle:Loueur:viewLoueur.html.twig', array('loueur'=>$loueur));
    }

}