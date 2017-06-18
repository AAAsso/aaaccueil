<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Application controller.
 *
 * @Route("application")
 */
class ApplicationController extends Controller
{
    /**
     * Lists all application entities.
     *
     * @Route("/liste", name="application_liste")
     * @Method("GET")
     */
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $applications = $em->getRepository('AppBundle:Application')->findAll();

        return $this->render('application/liste.html.twig', array(
            'applications' => $applications,
        ));
    }

    /**
     * Creates a new application entity.
     *
     * @Route("/nouveau", name="application_nouveau")
     * @Method({"GET", "POST"})
     */
    public function nouveauAction(Request $request)
    {
        $application = new Application();
        $form = $this->createForm('AppBundle\Form\ApplicationType', $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute('application_detail', array('slug' => $application->getSlug()));
        }

        return $this->render('application/nouveau.html.twig', array(
            'application' => $application,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a application entity.
     *
     * @Route("/{slug}", name="application_detail")
     * @Method("GET")
     */
    public function voirAction(Application $application)
    {
        $deleteForm = $this->createDeleteForm($application);

        return $this->render('application/detail.html.twig', array(
            'application' => $application,
            'form_supprimer' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing application entity.
     *
     * @Route("/editer/{slug}", name="application_editer")
     * @Method({"GET", "POST"})
     */
    public function editerAction(Request $request, Application $application)
    {
        $deleteForm = $this->createDeleteForm($application);
        $editForm = $this->createForm('AppBundle\Form\ApplicationType', $application);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('application_editer', array('slug' => $application->getSlug()));
        }

        return $this->render('application/editer.html.twig', array(
            'application'       => $application,
            'form_editer'       => $editForm->createView(),
            'form_supprimer'    => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a application entity.
     *
     * @Route("/supprimer/{id}", name="application_supprimer")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Application $application)
    {
        $form = $this->createDeleteForm($application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($application);
            $em->flush();
        }

        return $this->redirectToRoute('application_liste');
    }

    /**
     * Creates a form to delete a application entity.
     *
     * @param Application $application The application entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Application $application)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('application_supprimer', array('id' => $application->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
