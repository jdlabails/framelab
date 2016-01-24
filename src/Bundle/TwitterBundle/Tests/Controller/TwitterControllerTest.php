<?php

namespace Framelab\TwitterBundle\Tests\Controller;

use Framelab\MainBundle\Tests\Controller\MainControllerTest;

class TwitterControllerTest extends MainControllerTest
{
    public function testCompleteScenario()
    {
        $this->goAndCheckPage200('/retweetstat/');
        $this->goAndCheckPage200('/retweeter/new');
        $this->goAndCheckPage200('/retweeter/');
        $this->goAndCheckPage200('/retweeter/new');
    }
}
