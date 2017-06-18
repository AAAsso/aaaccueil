<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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

        return $this->render('notification/liste.html.twig', array(
            'notifications' => $notifications,
        ));
    }

    /**
     * Creates a new notification entity.
     *
     * @Route("/nouveau", name="notification_nouveau")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $notification = new Notification();
        $form = $this->createForm('AppBundle\Form\NotificationType', $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
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
     * Displays a form to editerer an existing notification entity.
     *
     * @Route("/editer/{slug}", name="notification_editer")
     * @Method({"GET", "POST"})
     */
    public function editererAction(Request $request, Notification $notification)
    {
        $deleteForm = $this->createDeleteForm($notification);
        $editererForm = $this->createForm('AppBundle\Form\NotificationType', $notification);
        $editererForm->handleRequest($request);

        if ($editererForm->isSubmitted() && $editererForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notification_editerer', array('slug' => $notification->getSlug()));
        }

        return $this->render('notification/editerer.html.twig', array(
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
    public function deleteAction(Request $request, Notification $notification)
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
            ->setAction($this->generateUrl('notification_delete', array('id' => $notification->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}