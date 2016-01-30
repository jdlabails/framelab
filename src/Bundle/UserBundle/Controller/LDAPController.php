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
        //die($this->essaiMano());
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

    /**
     * Fonction de debug qui envoi le ldap avec des fonctions natives
     */
//    private function essaiMano()
//    {
//        $basedn = 'dc=example,dc=com';  // two basedn
//        $filter = '(&(objectClass=*)(uid=*tesla*))';  // single filter
//        $attributes = array('dn', 'uid', 'sn');
//
//        $cnx = ldap_connect('ldap.forumsys.com', 389); // single connection
//        ldap_set_option($cnx, LDAP_OPT_PROTOCOL_VERSION, 3);
//
//        ldap_bind($cnx, 'cn=read-only-admin,dc=example,dc=com', 'password');  // authentication on two BDB
//
//        $search = ldap_search(array($cnx, $cnx, $cnx), $basedn, $filter);  // search
//
//        for ($i = 0; $i < count($search); $i++) {
//            //var_dump(ldap_get_entries($cnx, $search[$i]));
//            print "<br>";
//        }
//
//        $ldap_host = $this->container->getParameter('ldap_host');
//        $base_dn = $this->container->getParameter('ldap_baseDn');
//        $ldap_port = $this->container->getParameter('ldap_port');
//        $filter = $this->container->getParameter('ldap_filter');
//        $user = $this->container->getParameter('ldap_username');
//        $pwd = $this->container->getParameter('ldap_password');
//
//        $connect = ldap_connect($ldap_host, $ldap_port) or die(">>Could not connect to LDAP server<<");
//        ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
//        ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
//
//        // bind obligatoire apparemment
//        $bind = ldap_bind($connect, $user, $pwd) or die(">>Could not bind to $ldap_host<<");
//
//        $read = ldap_search($connect, $base_dn, $filter) or die(">>Unable to search ldap server<<");
//        //var_dump($read);
//        $info = ldap_get_entries($connect, $read);
//
//        echo $info["count"]." entries returned<p>";
//        $ii = 0;
//        for ($i = 0; $ii < $info[$i]["count"]; $ii++) {
//            $data = $info[$i][$ii];
//            echo $data.":&nbsp;&nbsp;".$info[$i][$data][0]."<br>";
//            //var_dump($info[$i]);
//        }
//        ldap_close($connect);
//    }
}
