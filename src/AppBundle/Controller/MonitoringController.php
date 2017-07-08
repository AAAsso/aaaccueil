<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Monitoring;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Monitoring controller.
 *
 * @Route("monitoring")
 */
class MonitoringController extends Controller
{
    /**
     * Lists all monitoring entities.
     *
     * @Route("/liste", name="monitoring_liste")
     * @Method("GET")
     */
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $monitorings = $em->getRepository('AppBundle:Monitoring')->findAll();
        $formsSupprimer = [];

        foreach($monitorings as $monitoring)
        {
            $formSupprimer = $this->creerFormSupprimer($monitoring);
            $formsSupprimer[$monitoring->getId()] = $formSupprimer->createView();
        }

        return $this->render('monitoring/liste.html.twig', array(
            'monitorings' => $monitorings,
            'forms_supprimer' => $formsSupprimer,
        ));
    }

    /**
     * Permet de lister les monitorings à afficher dans la navbar
     */
    public function navbarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $monitorings = $em->getRepository('AppBundle:Monitoring')->findAll();

        return $this->render('monitoring/navbar.html.twig', [
            'monitorings' => $monitorings,
        ]);
    }

    /**
     * Creates a new monitoring entity.
     *
     * @Route("/nouveau", name="monitoring_nouveau")
     * @Method({"GET", "POST"})
     */
    public function nouveauAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $monitoring = new Monitoring();
        $form = $this->createForm('AppBundle\Form\MonitoringType', $monitoring);
        $form->handleRequest($request);

        $monitoring->setDateCreation(new \DateTime());

        $session = new Session();
        $utilisateurConnecte = $session->get('utilisateur');
        $createur = $em->getRepository('AppBundle:Utilisateur')->find($utilisateurConnecte->getId());
        $monitoring->setCreateur($createur);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($monitoring);
            $em->flush();

            return $this->redirectToRoute('monitoring_detail', array('slug' => $monitoring->getSlug()));
        }

        return $this->render('monitoring/nouveau.html.twig', array(
            'monitoring' => $monitoring,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a monitoring entity.
     *
     * @Route("/{slug}", name="monitoring_detail")
     * @Method("GET")
     */
    public function detailAction(Monitoring $monitoring)
    {
        $formSupprimer = $this->creerFormSupprimer($monitoring);

        return $this->render('monitoring/detail.html.twig', array(
            'monitoring' => $monitoring,
            'form_supprimer' => $formSupprimer->createView(),
        ));
    }

    /**
     * Displays a form to editer an existing monitoring entity.
     *
     * @Route("/editer/{slug}", name="monitoring_editer")
     * @Method({"GET", "POST"})
     */
    public function editerAction(Request $request, Monitoring $monitoring)
    {
        $formSuppprimer = $this->creerFormSupprimer($monitoring);
        $formEditer = $this->createForm('AppBundle\Form\MonitoringType', $monitoring);
        $formEditer->handleRequest($request);

        if ($formEditer->isSubmitted() && $formEditer->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('monitoring_detail', array('slug' => $monitoring->getSlug()));
        }

        return $this->render('monitoring/editer.html.twig', array(
            'monitoring' => $monitoring,
            'form_editer' => $formEditer->createView(),
            'form_supprimer' => $formSuppprimer->createView(),
        ));
    }

    /**
     * Deletes a monitoring entity.
     *
     * @Route("/supprimer/{slug}", name="monitoring_supprimer")
     * @Method("DELETE")
     */
    public function supprimerAction(Request $request, Monitoring $monitoring)
    {
        $form = $this->creerFormSupprimer($monitoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($monitoring);
            $em->flush();
        }

        return $this->redirectToRoute('monitoring_liste');
    }

    /**
     * Creates a form to delete a monitoring entity.
     *
     * @param Monitoring $monitoring The monitoring entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function creerFormSupprimer(Monitoring $monitoring)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('monitoring_supprimer', array('slug' => $monitoring->getSlug())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
