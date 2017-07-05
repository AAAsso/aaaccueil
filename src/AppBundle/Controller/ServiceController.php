<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Service controller.
 *
 * @Route("service")
 */
class ServiceController extends Controller
{
    /**
     * Lists all service entities.
     *
     * @Route("/liste", name="service_liste")
     * @Method("GET")
     */
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('AppBundle:Service')->findAll();
        $formsSupprimer = [];

        foreach($services as $service)
        {
            $formSupprimer = $this->creerFormSupprimer($service);
            $formsSupprimer[$service->getId()] = $formSupprimer->createView();
        }

        return $this->render('service/liste.html.twig', array(
            'services' => $services,
            'forms_supprimer' => $formsSupprimer,
        ));
    }

    /**
     * Creates a new service entity.
     *
     * @Route("/nouveau", name="service_nouveau")
     * @Method({"GET", "POST"})
     */
    public function nouveauAction(Request $request)
    {
        $service = new Service();
        $form = $this->createForm('AppBundle\Form\ServiceType', $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('service_detail', array('id' => $service->getId()));
        }

        return $this->render('service/nouveau.html.twig', array(
            'service' => $service,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a service entity.
     *
     * @Route("/{id}", name="service_detail")
     * @Method("GET")
     */
    public function detailAction(Service $service)
    {
        $formSupprimer = $this->creerFormSupprimer($service);

        return $this->render('service/detail.html.twig', array(
            'service' => $service,
            'form_supprimer' => $formSupprimer->createView(),
        ));
    }

    /**
     * Displays a form to editer an existing service entity.
     *
     * @Route("/editer/{id}", name="service_editer")
     * @Method({"GET", "POST"})
     */
    public function editerAction(Request $request, Service $service)
    {
        $formSuppprimer = $this->creerFormSupprimer($service);
        $formEditer = $this->createForm('AppBundle\Form\ServiceType', $service);
        $formEditer->handleRequest($request);

        if ($formEditer->isSubmitted() && $formEditer->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_detail', array('id' => $service->getId()));
        }

        return $this->render('service/editer.html.twig', array(
            'service' => $service,
            'form_editer' => $formEditer->createView(),
            'form_supprimer' => $formSuppprimer->createView(),
        ));
    }

    /**
     * Deletes a service entity.
     *
     * @Route("/supprimer/{id}", name="service_supprimer")
     * @Method("DELETE")
     */
    public function supprimerAction(Request $request, Service $service)
    {
        $form = $this->creerFormSupprimer($service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($service);
            $em->flush();
        }

        return $this->redirectToRoute('service_liste');
    }

    /**
     * Creates a form to delete a service entity.
     *
     * @param Service $service The service entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function creerFormSupprimer(Service $service)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('service_supprimer', array('id' => $service->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
