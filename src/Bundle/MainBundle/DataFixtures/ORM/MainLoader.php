<?php

namespace Framelab\Bundle\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MainLoader implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $objectManager)
    {
        $objects = \Nelmio\Alice\Fixtures::load(
            __DIR__.'/test.yml',
            $objectManager,
            ['locale'=>'fr_FR']
        );

        $persister = new \Nelmio\Alice\ORM\Doctrine($objectManager);
        $persister->persist($objects);
    }
}
