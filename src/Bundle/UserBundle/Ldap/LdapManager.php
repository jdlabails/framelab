<?php

namespace Framelab\Bundle\UserBundle\Ldap;

use FR3D\LdapBundle\Ldap\LdapManager as BaseLdapManager;
use Symfony\Component\Security\Core\User\UserInterface;

class LdapManager extends BaseLdapManager
{
    protected function hydrate(UserInterface $user, array $entry)
    {
        parent::hydrate($user, $entry);

        //var_dump($user);

        $this->userManager->updateUser($user);

        // Your custom code
        //$user->setEmail('');
        //$user->setEmailCanonical('');

        // un petit message en flash bag pour commencer
    }
}
