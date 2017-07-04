<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class MainController extends Controller
{

    /**
     * @Route("/", name="aaaccueil")
     */
    public function indexAction(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();

        // TODO  : Faire la même chose pour les annonces que pour les évents
        $annonces = $em->getRepository('AppBundle:Annonce')->findPublicatedOnes();

        if ($session->get('estConnecte'))
        {
            $evenements = $em->getRepository('AppBundle:Evenement')->findComingOnes();
        }
        else
        {
            $evenements = $em->getRepository('AppBundle:Evenement')->findComingAndPublicOnes();
        }

        $evenementsTriesParDate = [];

        foreach ($evenements as $evenement)
        {
            $dateFormatee = date_format($evenement->getDateDebut(), 'Y-m-d');
            $evenementsTriesParDate[$dateFormatee][] = $evenement;
        }

        return $this->render('index/index.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
                'annonces' => $annonces,
                'evenements' => $evenements,
                'evenements_tries' => $evenementsTriesParDate,
        ]);
    }

}
