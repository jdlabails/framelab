<?php

namespace Framelab\Bundle\TwitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Framelab\Bundle\TwitterBundle\Entity\Retweeter;
use Framelab\Bundle\TwitterBundle\Form\RetweeterType;

/**
 * Retweeter controller.
 *
 * @Route("/retweeter")
 */
class RetweeterController extends Controller
{
    /**
     * Lists all Retweeter entities.
     *
     * @Route("/{id}/launch", name="retweeter_launch")
     * @Method("GET")
     */
    public function launchAction(Retweeter $retweeter)
    {
        if ($this->get('twitter.retweeter')->launch($retweeter)) {
            $this->addFlash('success', 'Launch ok');
        } else {
            $this->addFlash('error', 'Launch ko : '.$this->get('twitter.retweeter')->getExplaination());
        }

        return $this->redirect($this->generateUrl("retweeter_index"));
    }

    /**
     * Lists all Retweeter entities.
     *
     * @Route("/", name="retweeter_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $retweeters = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TwitterBundle:Retweeter')
            ->findAll();

        return $this->render('TwitterBundle:Retweeter:index.html.twig', ['retweeters' => $retweeters]);
    }

    /**
     * Creates a new Retweeter entity.
     *
     * @Route("/new", name="retweeter_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $retweeter = new Retweeter();
        $form = $this->createForm(
            'Framelab\Bundle\TwitterBundle\Form\RetweeterType',
            $retweeter,
            [
                'action' => $this->generateUrl('retweeter_new'),
                'method' => 'POST',
            ]
        );
        $form->add('submit', 'submit', ['label' => 'Create', 'attr' => ['class' => 'btn btn-success']]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($retweeter);
            $em->flush();

            return $this->redirectToRoute('retweeter_index');
        }

        return $this->render(
            'TwitterBundle:Retweeter:new.html.twig',
            [
                'retweeter' => $retweeter,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing Retweeter entity.
     *
     * @Route("/{id}/edit", name="retweeter_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Retweeter $retweeter)
    {
        $deleteForm = $this->createDeleteForm($retweeter);
        $editForm = $this->createForm('Framelab\Bundle\TwitterBundle\Form\RetweeterType', $retweeter);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($retweeter);
            $em->flush();

            return $this->redirectToRoute('retweeter_index');
        }

        return $this->render(
            'TwitterBundle:Retweeter:edit.html.twig',
            [
                'retweeter' => $retweeter,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Deletes a Retweeter entity.
     *
     * @Route("/{id}", name="retweeter_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Retweeter $retweeter)
    {
        $form = $this->createDeleteForm($retweeter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($retweeter);
            $em->flush();
        }

        return $this->redirectToRoute('retweeter_index');
    }

    /**
     * Creates a form to delete a Retweeter entity.
     *
     * @param Retweeter $retweeter The Retweeter entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Retweeter $retweeter)
    {
        return $this->createFormBuilder()
                ->setAction($this->generateUrl('retweeter_delete', array('id' => $retweeter->getId())))
                ->setMethod('DELETE')
                ->getForm();
    }
}
