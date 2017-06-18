<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FooterController extends Controller
{
    /**
     * @Route("/a_propos", name="a_propos")
     */
    public function a_proposAction()
    {
        return $this->render('AppBundle:Footer:a.propos.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/equipe", name="equipe")
     */
    public function equipeAction()
    {
        return $this->render('AppBundle:Footer:equipe.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/plan_du_site", name="plan_du_site")
     */
    public function plan_du_siteAction()
    {
        return $this->render('AppBundle:Footer:plan.du.site.html.twig', array(
            // ...
        ));
    }

}
