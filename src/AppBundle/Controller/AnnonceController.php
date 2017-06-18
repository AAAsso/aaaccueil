<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AnnonceController extends Controller
{
    /**
     * @Route("/annonce/nouveau", name="annonce_nouveau")
     */
    public function nouveauAction()
    {
        return $this->render('AppBundle:Annonce:nouveau.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/annonces", name="annonce_liste")
     */
    public function listeAction()
    {
        return $this->render('AppBundle:Annonce:liste.html.twig', array(
            // ...
        ));
    }

}
