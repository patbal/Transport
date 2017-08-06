<?php

namespace PB\TransportBundle\Controller;

use PB\TransportBundle\Entity\Factures;
use PB\TransportBundle\Form\FacturesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdresseController extends Controller
{

    // *************************************************************************************************
    // **************************************** ADRESSES ***********************************************
    // *************************************************************************************************


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

}
