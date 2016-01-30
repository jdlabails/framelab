<?php

namespace Framelab\Bundle\RateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RateController extends Controller
{
    public function likeAction(Request $request)
    {
        $id = $request->get('id');

        if ($this->get('rate_manager')->save($id)) {
            return new Response('ok', 200, array('content-type' => 'text/html'));
        }

        return new Response('who are you', 400, array('content-type' => 'text/html'));
    }

    /**
     * Displays a "like" button or display "you like or not it".
     */
    public function likeButtonAction($id, $type)
    {
        $isLike = $this->get('rate_manager')->isLikedByCurrentUser($type.'_'.$id);

        return $this->render(
            'RateBundle:Rate:likeButton.html.twig',
            [
            'type'   => $type,
            'id'     => $id,
            'isLike' => $isLike
            ]
        );
    }

    /**
     * Displays nb like
     */
    public function nbLikeAction($id, $type)
    {
        $nb = $this->get('rate_manager')->getNbLike($type.'_'.$id);

        return $this->render(
            'RateBundle:Rate:nbLike.html.twig',
            [
                'type'  => $type,
                'id'    => $id,
                'nb'    => $nb
            ]
        );
    }
}
