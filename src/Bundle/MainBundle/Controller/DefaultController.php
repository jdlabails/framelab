<?php

namespace Framelab\Bundle\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * DefaultController.
 *
 */
class DefaultController extends Controller
{

    public function indexAction()
    {

        return $this->render('MainBundle:Default:index.html.twig');
    }

}