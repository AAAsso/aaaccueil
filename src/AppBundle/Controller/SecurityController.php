<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SecurityController extends Controller
{

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $login = $request->get('login');

        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->utilisateurExiste($login);

        $session = new Session();

        if (!is_null($utilisateur))
        {
            $mdp = $request->get('mdp');

            if ($mdp === $utilisateur->getMdp())
            {
                // Ajout de message d'alerte
                $session->getFlashBag()->add(
                        'success', 'Bienvenue '.$utilisateur->getPseudo()
                );

                $session->set('estConnecte', true);
                $session->set('utilisateur', $utilisateur);
                $session->set('notificationsNonLues', $utilisateur->getNotificationsNonLues());
            }
            else
            {
                // Ajout de message d'alerte
                $session->getFlashBag()->add(
                        'danger', 'Mot de passe incorrect.'
                );
            }
        }
        else
        {
            // Ajout de message d'alerte
            $session->getFlashBag()->add(
                    'danger', 'Login incorrect.'
            );
        }

        return $this->redirectToRoute('aaaccueil');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        $session = new Session();
        $session->clear();

        return $this->redirectToRoute('aaaccueil');
    }
}