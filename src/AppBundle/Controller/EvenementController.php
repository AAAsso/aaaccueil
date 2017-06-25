<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Evenement controller.
 *
 * @Route("evenement")
 */
class EvenementController extends Controller
{
    /**
     * Lists all evenement entities.
     *
     * @Route("/", name="evenement_liste")
     * @Method("GET")
     */
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('AppBundle:Evenement')->findAll();

        $deleteForms = [];

        foreach($evenements as $evenement)
        {
            $deleteForm = $this->createDeleteForm($evenement);
            $deleteForms[$evenement->getId()] = $deleteForm->createView();
        }

        return $this->render('evenement/liste.html.twig', [
            'evenements' => $evenements,
            'forms_supprimer' => $deleteForms,
        ]);
    }

    /**
     * Creates a new evenement entity.
     *
     * @Route("/nouveau", name="evenement_nouveau")
     * @Method({"GET", "POST"})
     */
    public function nouveauAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $evenement = new Evenement();
        $form = $this->createForm('AppBundle\Form\EvenementType', $evenement);
        $form->handleRequest($request);

        $evenement->setDateCreation(new \DateTime());

        $session = new Session();
        $createur = $session->get('utilisateur');
        $evenement->setCreateur($createur);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            return $this->redirectToRoute('evenement_detail', ['slug' => $evenement->getSlug()]);
        }

        return $this->render('evenement/nouveau.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a evenement entity.
     *
     * @Route("/{slug}", name="evenement_detail")
     * @Method("GET")
     */
    public function detailAction(Evenement $evenement)
    {
        $deleteForm = $this->createDeleteForm($evenement);

        return $this->render('evenement/detail.html.twig', array(
            'evenement' => $evenement,
            'form_supprimer' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing evenement entity.
     *
     * @Route("/editer/{slug}", name="evenement_editer")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Evenement $evenement)
    {
        $deleteForm = $this->createDeleteForm($evenement);
        $editForm = $this->createForm('AppBundle\Form\EvenementType', $evenement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_detail', ['slug' => $evenement->getSlug()]);
        }

        return $this->render('evenement/editer.html.twig', [
            'evenement' => $evenement,
            'form_editer' => $editForm->createView(),
            'form_supprimer' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a evenement entity.
     *
     * @Route("/supprimer/{slug}", name="evenement_supprimer")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Evenement $evenement)
    {
        $form = $this->createDeleteForm($evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
        }

        return $this->redirectToRoute('evenement_liste');
    }

    /**
     * Creates a form to delete a evenement entity.
     *
     * @param Evenement $evenement The evenement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Evenement $evenement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evenement_supprimer', ['slug' => $evenement->getSlug()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
