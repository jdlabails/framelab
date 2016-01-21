<?php

namespace Framelab\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Framelab\Bundle\UserBundle\Entity\User;
use Framelab\Bundle\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render('UserBundle:User:index.html.twig', array('users'=>$users));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UserBundle:User:show.html.twig', array(
            'entity'      => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function newAction()
    {
        $user = new User();

        $form = $this->createNewForm($user);

        return $this->render('UserBundle:User:new.html.twig', array(
            'user'      => $user,
            'form'  => $form->createView()
        ));
    }

    /**
    * Creates a form to create a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createNewForm(User $entity)
    {
        $form = $this->createForm(new UserType($this->container->getParameter('security.role_hierarchy.roles')), $entity, array(
            'action' => $this->generateUrl('atelier_user_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($user);

        return $this->render('UserBundle:User:edit.html.twig', array(
            'user'      => $user,
            'edit_form'   => $editForm->createView()
        ));
    }

    /**
     * cfreates an existing User entity.
     *
     */
    public function createAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $form = $this->createNewForm($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->setDn('');
            $userManager->updateUser($user);

            return $this->redirect($this->generateUrl('atelier_user_index'));
        }

        return $this->render('UserBundle:User:new.html.twig', array(
            'entity' => $user,
            'form'   => $form->createView()
        ));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType($this->container->getParameter('security.role_hierarchy.roles')), $entity, array(
            'action' => $this->generateUrl('atelier_user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($user);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $userManager->updateUser($user);

            return $this->redirect($this->generateUrl('atelier_user_edit', array('id' => $id)));
        }

        return $this->render('UserBundle:User:edit.html.twig', array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView()
        ));
    }
    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('atelier_user_index'));
    }
}
