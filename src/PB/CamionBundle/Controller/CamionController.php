<?php

namespace PB\CamionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CamionController extends Controller
{
    public function indexAction()
    {
        return $this->render('PBCamionBundle:Camion:index.html.twig');
    }
}
