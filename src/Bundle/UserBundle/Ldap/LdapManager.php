<?php

namespace Framelab\Bundle\UserBundle\Ldap;

use FR3D\LdapBundle\Ldap\LdapManager as BaseLdapManager;
use Symfony\Component\Security\Core\User\UserInterface;

class LdapManager extends BaseLdapManager
{
    protected function hydrate(UserInterface $user, array $entry)
    {
        parent::hydrate($user, $entry);

        $this->userManager->updateUser($user);
    }
}
