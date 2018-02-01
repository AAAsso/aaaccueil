<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Notification controller.
 *
 * @Route("notification")
 */
class NotificationController extends Controller
{
    /**
     * Lists all notification entities.
     *
     * @Route("/liste", name="notification_liste")
     * @Method("GET")
     */
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('AppBundle:Notification')->findAll();

        $deleteForms = [];

        foreach ($notifications as $notification)
        {
            $deleteForm = $this->createDeleteForm($notification);
            $deleteForms[$notification->getId()] = $deleteForm->createView();
        }

        return $this->render('notification/liste.html.twig', [
            'notifications' => $notifications,
            'forms_supprimer' => $deleteForms,
        ]);
    }
    
    private function refreshNotifications()
    {
        // Initialisation des objets utiles
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $notificationsLuesFormatees = array();
        $notificationsNonLuesFormatees = array();

        // On récupère les dix dernières notifications (qu'elles soient lues ou pas)
        $dernieresNotifications = $em->getRepository('AppBundle:Notification')->findLatest();

        // On récupère les notifications qui n'ont pas été lues pas l'utilisateur
        $idUtilisateurConnecte = $session->get('utilisateur')->getId();
        $utilisateurConnecte = $em->getRepository('AppBundle:Utilisateur')->find($idUtilisateurConnecte);
        $notificationsNonLues = $utilisateurConnecte->getNotificationsNonLues();
        $session->set('nbNotificationsNonLues', count($notificationsNonLues));

        foreach($dernieresNotifications as $notification)
        {
            $notificationEstLue = true;

            foreach($notificationsNonLues as $notificationNonLue)
            {
                if($notification->getId() === $notificationNonLue->getId())
                {
                    $notificationEstLue = false;
                    break;
                }
            }

            if($notificationEstLue)
            {
                $notificationsLuesFormatees[] = array('notification' => $notification, 'lue' => true);
            }
            else
            {
                $notificationsNonLuesFormatees[] = array('notification' => $notification, 'lue' => false);
            }
        } 

        return array_merge($notificationsNonLuesFormatees, $notificationsLuesFormatees);
    }

    public function navbarAction()
    {
        $notifications = $this->refreshNotifications();

        return $this->render('notification/navbar.html.twig', array(
            'notifications' => $notifications,
        ));
    }

    /**
     * Retourne les données à jour pour la liste des notifications.
     *
     * @Route("/ajax", name="notification_ajax")
     * @Method("GET")
     */
    public function ajaxAction()
    {
        $session = new Session();
        
        $notifications = $this->refreshNotifications();
        $nbNotificationsNonLues = $session->get('nbNotificationsNonLues');
        
        $listeNotifications = $this->forward('notification/navbar.html.twig', array(
            'notifications' => $notifications,
        ))->getContent();
                
        $json = json_encode(array(
            'listeNotifications' => $listeNotifications,
            'nbNotificationsNonLues' => $nbNotificationsNonLues
        ), true);
        
        $response = new Response($json, 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Creates a new notification entity.
     *
     * @Route("/nouveau", name="notification_nouveau")
     * @Method({"GET", "POST"})
     */
    public function nouveauAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $notification = new Notification();
        $form = $this->createForm('AppBundle\Form\NotificationType', $notification);
        $form->handleRequest($request);

        $notification->setDateCreation(new \DateTime());

        $session = new Session();
        $utilisateurConnecte = $session->get('utilisateur');
        $createur = $em->getRepository('AppBundle:Utilisateur')->find($utilisateurConnecte->getId());
        $notification->setCreateur($createur);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // On récupère la liste des utilisateurs pour pouvoir leur associer la notification.
            $utilisateurs = $em->getRepository('AppBundle:Utilisateur')->findAll();
            // Pour chaque utilisateur on associe la notification et on le persist.
            foreach($utilisateurs as $utilisateur)
            {
                $utilisateur->addNotificationsNonLues($notification);
                $em->persist($utilisateur);
            }
            $em->persist($notification);
            $em->flush();

            return $this->redirectToRoute('notification_detail', array('slug' => $notification->getSlug()));
        }

        return $this->render('notification/nouveau.html.twig', array(
            'notification' => $notification,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a notification entity.
     *
     * @Route("/{slug}", name="notification_detail")
     * @Method("GET")
     */
    public function detailAction(Notification $notification)
    {
        $deleteForm = $this->createDeleteForm($notification);

        return $this->render('notification/detail.html.twig', array(
            'notification' => $notification,
            'form_supprimer' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing notification entity.
     *
     * @Route("/editer/{slug}", name="notification_editer")
     * @Method({"GET", "POST"})
     */
    public function editerAction(Request $request, Notification $notification)
    {
        $deleteForm = $this->createDeleteForm($notification);
        $editererForm = $this->createForm('AppBundle\Form\NotificationType', $notification);
        $editererForm->handleRequest($request);

        if ($editererForm->isSubmitted() && $editererForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notification_detail', array('slug' => $notification->getSlug()));
        }

        return $this->render('notification/editer.html.twig', array(
            'notification' => $notification,
            'form_editer' => $editererForm->createView(),
            'form_supprimer' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a notification entity.
     *
     * @Route("/supprimer/{id}", name="notification_supprimer")
     * @Method("DELETE")
     */
    public function supprimerAction(Request $request, Notification $notification)
    {
        $form = $this->createDeleteForm($notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notification);
            $em->flush();
        }

        return $this->redirectToRoute('notification_liste');
    }

    /**
     * Creates a form to delete a notification entity.
     *
     * @param Notification $notification The notification entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Notification $notification)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notification_supprimer', array('id' => $notification->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
