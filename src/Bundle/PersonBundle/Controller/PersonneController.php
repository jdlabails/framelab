<?php

namespace Framelab\Bundle\PersonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Framelab\Bundle\PersonBundle\Entity\Personne;
use Framelab\Bundle\PersonBundle\Form\PersonneType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Personne controller.
 *
 */
class PersonneController extends Controller
{
    /**
     * Lists all Personne entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PersonBundle:Personne')->findAll();

        return $this->render('PersonBundle:Personne:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Personne entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Personne();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('personne'));
        }

        return $this->render('PersonBundle:Personne:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Personne entity.
     *
     * @param Personne $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Personne $entity)
    {
        $form = $this->createForm(PersonneType::class, $entity, array(
            'action' => $this->generateUrl('personne_create'),
            'method' => 'POST',
        ));

        $form->add(
            'submit',
            SubmitType::class,
            array('label' => 'Create', 'attr' => array('class' => 'btn btn-success'))
        );

        return $form;
    }

    /**
     * Displays a form to create a new Personne entity.
     *
     */
    public function newAction()
    {
        $entity = new Personne();
        $form   = $this->createCreateForm($entity);

        return $this->render('PersonBundle:Personne:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Personne entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PersonBundle:Personne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personne entity.');
        }

        return $this->render('PersonBundle:Personne:show.html.twig', array(
            'entity'      => $entity
        ));
    }

    /**
     * Displays a form to edit an existing Personne entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PersonBundle:Personne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personne entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('PersonBundle:Personne:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }

    /**
    * Creates a form to edit a Personne entity.
    *
    * @param Personne $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Personne $entity)
    {
        $form = $this->createForm(PersonneType::class, $entity, array(
            'action' => $this->generateUrl('personne_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Personne entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PersonBundle:Personne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personne entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('personne'));
        }

        return $this->render('PersonBundle:Personne:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }
    /**
     * Deletes a Personne entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PersonBundle:Personne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personne entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('personne'));
    }
}
