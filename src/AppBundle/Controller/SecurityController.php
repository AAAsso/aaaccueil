<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $login = $request->get('login');

        $utilisateurExiste = $em->getRepository('AppBundle:Utilisateur')->utilisateurExiste($login);

        $message = array();
        $message['type'] = 'warning';
        $message['contenu'] = 'teste';

        if(!is_null($utilisateurExiste))
        {
            $mdp = $request->get('mdp');

        }
        else
        {

        }

        return $this->forward('AppBundle:Main:index', array(
            'message'  => $message,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        return $this->render('index/index.html.twig', array(
            // ...
        ));
    }

}
