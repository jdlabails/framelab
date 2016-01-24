<?php

namespace Framelab\DocumentBundle\Tests\Controller;

use Framelab\MainBundle\Tests\Controller\MainControllerTest;

class DocumentControllerTest extends MainControllerTest
{
    public function testCompleteScenario()
    {
        $this->goAndCheckPage200('/document/new');
        $this->goAndCheckPage200('/document/');
    }
}
