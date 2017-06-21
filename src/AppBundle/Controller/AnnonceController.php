<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Annonce controller.
 *
 * @Route("annonce")
 */
class AnnonceController extends Controller
{
    /**
     * Lists all annonce entities.
     *
     * @Route("/liste", name="annonce_liste")
     * @Method("GET")
     */
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository('AppBundle:Annonce')->findAll();

        $deleteForms = array();

        foreach($annonces as $annonce)
        {
            $deleteForm = $this->createDeleteForm($annonce);
            $deleteForms[$annonce->getId()] = $deleteForm->createView();
        }

        return $this->render('annonce/liste.html.twig', array(
            'annonces' => $annonces,
            'forms_supprimer' => $deleteForms,
        ));
    }

    /**
     * Creates a new annonce entity.
     *
     * @Route("/nouveau", name="annonce_nouveau")
     * @Method({"GET", "POST"})
     */
    public function nouveauAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $annonce = new Annonce();
        $form = $this->createForm('AppBundle\Form\AnnonceType', $annonce);
        $form->handleRequest($request);

        $annonce->setDateCreation(new \DateTime());
        // TODO:
        // Remplacer l'id 2 par l'id de l'utilisateur connecté
        $createur = $em->getRepository('AppBundle:Utilisateur')->find(2);
        $annonce->setCreateur($createur);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('annonce_detail', array('slug' => $annonce->getSlug()));
        }

        return $this->render('annonce/nouveau.html.twig', array(
            'annonce' => $annonce,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a annonce entity.
     *
     * @Route("/{slug}", name="annonce_detail")
     * @Method("GET")
     */
    public function detailAction(Annonce $annonce)
    {
        $deleteForm = $this->createDeleteForm($annonce);

        return $this->render('annonce/detail.html.twig', array(
            'annonce' => $annonce,
            'form_supprimer' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing annonce entity.
     *
     * @Route("/editer/{slug}", name="annonce_editer")
     * @Method({"GET", "POST"})
     */
    public function editerAction(Request $request, Annonce $annonce)
    {
        $deleteForm = $this->createDeleteForm($annonce);
        $editForm = $this->createForm('AppBundle\Form\AnnonceType', $annonce);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonce_detail', array('slug' => $annonce->getSlug()));
        }

        return $this->render('annonce/editer.html.twig', array(
            'annonce' => $annonce,
            'form_editer' => $editForm->createView(),
            'form_supprimer' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a annonce entity.
     *
     * @Route("/supprimer/{id}", name="annonce_supprimer")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Annonce $annonce)
    {
        $form = $this->createDeleteForm($annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($annonce);
            $em->flush();
        }

        return $this->redirectToRoute('annonce_liste');
    }

    /**
     * Creates a form to delete a annonce entity.
     *
     * @param Annonce $annonce The annonce entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Annonce $annonce)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annonce_supprimer', array('id' => $annonce->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
