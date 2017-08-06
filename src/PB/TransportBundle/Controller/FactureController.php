<?php

namespace PB\TransportBundle\Controller;

use PB\TransportBundle\Entity\Factures;
use PB\TransportBundle\Form\FacturesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FactureController extends Controller
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

        $transports = $this -> getDoctrine()->getRepository('PBTransportBundle:Transport')->findByfacture($facture->getId());

        return $this -> render('PBTransportBundle:Transport:viewFacture.html.twig', array('facture'=>$facture, 'transports'=>$transports));
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

            return $this->redirectToRoute('pb_transport_viewfacture', ['id'=>$facture->getId()]);
        }

        return $this->render('PBTransportBundle:Transport:editFacture.html.twig', array('facture'=>$facture, 'form'=>$form->createView(),  'titre' => "Modification de facture", 'boutonDel' => true));
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

        return $this -> redirectToRoute('pb_transport_viewfactures');
    }


}
