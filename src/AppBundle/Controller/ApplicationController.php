<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ApplicationController extends Controller
{
    /**
     * @Route("/application/nouveau", name="application_nouveau")
     */
    public function nouveauAction()
    {
        return $this->render('AppBundle:Application:nouveau.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/applications/", name="application_liste")
     */
    public function listeAction()
    {
        return $this->render('AppBundle:Application:liste.html.twig', array(
            // ...
        ));
    }

}
