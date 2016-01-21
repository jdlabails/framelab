<?php

namespace Framelab\Bundle\DocumentBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Framelab\Bundle\DocumentBundle\Entity\Document;

class DocumentConfigurationSubscriber implements EventSubscriber
{
    /**
     * @var : root upload dir
     */
    private $uploadRootDir;

    /**
     * @var : relative upload dir (from root)
     */
    private $uploadDir;

    /**
     * @var : token Storage
     */
    private $tokenStorage;

    /**
     * @param $uploadRootDir
     * @param $uploadDir
     * @param TokenStorage  $tokenStorage
     */
    public function __construct($uploadRootDir, $uploadDir, TokenStorage $tokenStorage)
    {
        //affect given args from service
        $this->uploadRootDir = $uploadRootDir.'/../web/';
        $this->uploadDir = $uploadDir;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Subscribe to doctrine postLoad events.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
            'prePersist',
            'preUpdate',
            'preRemove',
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        //affect upload dirs conf
        $this->affectUploadConfiguration($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        //affect upload dirs conf
        $this->affectUploadConfiguration($args);
        //inject owner informations with security.token_storage
        $this->affectUser($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        //affect upload dirs conf
        $this->affectUploadConfiguration($args);
        //inject owner informations with security.token_storage
        $this->affectUser($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        //affect upload dirs conf
        $this->affectUploadConfiguration($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function affectUploadConfiguration(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Document) {
            $entity->setUploadRootDir($this->uploadRootDir);
            $entity->setUploadDir($this->uploadDir);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function affectUser(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Document) {
            $entity->setOwner($this->tokenStorage->getToken()->getUser());
        }
    }
}
