<?php

namespace Framelab\Bundle\RateBundle\Services;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Doctrine\ORM\EntityManager;

use Framelab\Bundle\UserBundle\Entity\User;
use Framelab\Bundle\RateBundle\Entity\Rate;

class RateManager
{
    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param SecurityContext $securityContext
     */
    public function __construct(TokenStorage $tokenStorage, EntityManager $entityManager)
    {
        $this->tokenStorage  = $tokenStorage;
        $this->entityManager = $entityManager;
    }

    /**
     * Sauve un vote
     *
     * @param string $ratableId
     *
     * @return boolean
     */
    public function save($ratableId)
    {
        $usr = $this->getCurrentUser();

        if ($usr instanceof User) {
            $entity = new Rate();

            $entity->setDate(new \DateTime);
            $entity->setUser($usr);
            $entity->setRatable($ratableId);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }

    /**
     * Renvoi vrai si l'utilisateur courant aime cet item
     * @param type $ratableId
     * @return type
     */
    public function isLikedByCurrentUser($ratableId)
    {
        $rate = $this
            ->entityManager
            ->getRepository('RateBundle:Rate')
            ->findOneBy(
                [
                    'ratable' => $ratableId,
                    'user' => $this->getCurrentUser()
                ]
            );

        return !empty($rate);
    }

    /**
     * Renvoi ne nb de like sur une instance
     * @param type $ratableId
     * @return type
     */
    public function getNbLike($ratableId)
    {
        $rates = $this
            ->entityManager
            ->getRepository('RateBundle:Rate')
            ->findBy(['ratable' => $ratableId]);

        return count($rates);
    }

    /**
     * Retourne l'utilisateur courant
     * @return User
     */
    private function getCurrentUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}
