<?php

namespace Framelab\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Framelab\Bundle\UserBundle\Entity\User;

class LDAPController extends Controller
{
    /**
     * Affiche l'interface de recherche  sur LDAP
     * @return type
     */
    public function rechercherAction()
    {
        $users = array();
        $search = $this->getRequest()->get('search');

        if (trim($search) != '') {
            $dn = $this->container->getParameter('ldap_baseDn');
            $ldapManager = $this->get('fr3d_ldap.ldap_driver');
            $filter = str_replace('%s', $search, $this->container->getParameter('ldap_filterSearch'));
            $users = $ldapManager->search($dn, $filter, array('cn', 'title', 'samaccountname', 'mail'));
            unset($users['count']);
        }

        return $this->render('UserBundle:LDAP:recherche.html.twig', array('res' => $users, 'search' => $search));
    }

    /**
     * Affiche l'interface de recherche  sur LDAP
     * @return type
     */
    public function explorerAction()
    {
        $users = array();
        $search = $this->getRequest()->get('search');

        if (trim($search) != '') {
            $dn = $this->container->getParameter('ldap_baseDn');
            $ldapManager = $this->get('fr3d_ldap.ldap_driver');
            $filter = str_replace('%s', $search, $this->container->getParameter('ldap_filterSearch'));
            $users = $ldapManager->search($dn, $filter);
            unset($users['count']);
        }

        return $this->render('UserBundle:LDAP:index.html.twig', array('res' => $users, 'search' => $search));
    }

    /**
     * Gère le clic sur le bouton ajouter d'un user LDAP pour l'importer en user sesam
     * Redirige sur la page de listing des utilisateurs
     * @param type $userName
     * @return type
     */
    public function addAction($userName)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($userName);
        if ($user instanceof User) {
            $session = $this->get('session');
            $session->getFlashBag()->add('warning', 'Utilisateur déjà Sesamé !');
        } else {

            $ldapUserProvider = $this->get('fr3d_ldap.security.user.provider');
            $user = $ldapUserProvider->loadUserByUsername($userName);

            if ($user instanceof User) {
                $user->addRole('ROLE_USER');
                $userManager = $this->get('fos_user.user_manager');
                $userManager->updateUser($user);
            } else {
                $session = $this->get('session');
                $session->getFlashBag()->add('error', 'Utilisateur inconnu sur le LDAP');
            }
        }

        return $this->redirect($this->generateUrl('atelier_user_index'));
    }
}
