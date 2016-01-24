<?php

namespace Framelab\UserBundle\Tests\Controller;

use Framelab\MainBundle\Tests\Controller\MainControllerTest;

class DefaultControllerTest extends MainControllerTest
{
    public function testIndex()
    {
        $this->goAndCheckPage200('/user/new');
        $this->goAndCheckPage200('/user/');
    }
}
