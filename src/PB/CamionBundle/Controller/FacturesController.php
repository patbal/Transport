<?php

namespace PB\CamionBundle\Controller;

use PB\CamionBundle\Entity\Factures;
use PB\CamionBundle\Form\FacturesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FacturesController extends Controller
{

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

            return $this->redirectToRoute('pb_camion_viewfactures');
        }

        return $this->render('PBCamionBundle:Factures:editFacture.html.twig', array('facture'=>$facture, 'form' => $form->createView(), 'titre'=>'Entrée d\'une facture', 'boutonDel' => true));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewFacturesAction(Request $request)
    {

        $nbPerPage = $this -> container -> getParameter('nb_per_page');

        $listeFactures = $this->getDoctrine()
            ->getManager()
            ->getRepository('PBCamionBundle:Factures')
            ->getFactures();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($listeFactures, $request->query->getInt('page', 1),$nbPerPage);

        return $this->render('PBCamionBundle:Factures:viewFactures.html.twig', array(
            'listFactures' => $pagination));
    }

    /**
     * @param Factures $facture
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewFactureAction(Factures $facture, $id)
    {
        if (null === $facture) {
            throw new NotFoundHttpException('Facture inexistante.');
        }

        $camions = $this -> getDoctrine()->getRepository('PBCamionBundle:Camion')->findByfacture($facture->getId());

        return $this -> render('PBCamionBundle:Factures:viewFacture.html.twig', array('facture'=>$facture, 'camions'=>$camions));
    }

    /**
     * @param Factures $facture
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editFactureAction(Factures $facture, $id, Request $request)
    {
        if (null === $facture) {
            throw new NotFoundHttpException('Facture inexistante.');
        }

        $form = $this -> get('form.factory')->create(FacturesType::class, $facture);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em -> persist($facture);
            $em -> flush();

            $request->getSession()->getFlashBag()->add('notice', 'Facture modifiée.');

            return $this->redirectToRoute('pb_camion_viewfacture', ['id'=>$facture->getId()]);
        }

        return $this->render('PBCamionBundle:Factures:editFacture.html.twig', array('facture'=>$facture, 'form'=>$form->createView(),  'titre' => "Modification de facture", 'boutonDel' => true));
    }

    /**
     * @param Factures $facture
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteFactureAction(Factures $facture, $id, Request $request)
    {
        if (null === $facture)
        {
            throw new NotFoundHttpException("Cette facture n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $em -> remove($facture);
        $request->getSession()->getFlashBag()->add('alert', 'Facture n° '.$facture->getNumerofacture().' supprimée.');
        $em -> flush();

        return $this -> redirectToRoute('pb_camion_viewfactures');
    }


}
