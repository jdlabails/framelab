<?php

namespace Framelab\Bundle\TwitterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Framelab\Bundle\TwitterBundle\Entity\RetweetStat;

/**
 * RetweetStat controller.
 *
 * @Route("/retweetstat")
 */
class RetweetStatController extends Controller
{

    /**
     * Lists all RetweetStat entities.
     *
     * @Route("/", name="retweetstat_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $retweetStats = $em->getRepository('TwitterBundle:RetweetStat')->findAll();
        $retweetersEntities = $em->getRepository('TwitterBundle:Retweeter')->findAll();
        $retweeters = [];
        foreach ($retweetersEntities as $retweeter) {
            $retweeters[$retweeter->getId()] = $retweeter->getName();
        }

        return $this->render(
            'TwitterBundle:Retweetstat:index.html.twig',
            [
                'retweetStats' => $retweetStats,
                'retweeters' => $retweeters
            ]
        );
    }

    /**
     * Finds and displays a RetweetStat entity.
     *
     * @Route("/{id}", name="retweetstat_show")
     * @Method("GET")
     */
    public function showAction(RetweetStat $retweetStat)
    {
        return $this->render(
            'TwitterBundle:Retweetstat:show.html.twig',
            [
                'retweetStat' => $retweetStat,
                'delete_form' => $this->createDeleteForm($retweetStat)->createView(),
            ]
        );
    }
}
