<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="aaaccueil")
     */
    public function indexAction(Request $request)
    {       
        // Pour le moment on revoie sur la page par défaut.
        // Il faudra faire une belle page d'aaacceuil correspondate aux maquettes.
        return $this->render('index/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
