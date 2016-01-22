<?php

namespace Framelab\Bundle\PostBundle\Tests\Controller;

use Framelab\MainBundle\Tests\Controller\MainControllerTest;

class PostControllerTest extends MainControllerTest
{
    public function testCompleteScenario()
    {
        $this->goAndCheckPage200('/article/');
        $this->goAndCheckPage200('/article/new');
    }
}
