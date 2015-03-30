<?php

namespace Tony\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tony\UserBundle\Entity\User;
class CallbackHandlerController extends Controller
{
    public function indexAction()
    {

        $request = Request::createFromGlobals();

//        $em = $request->server->get('connection_token');
        $em = $request->request->get('connection_token');
        if ( ! empty ($em))
        {

            return $this->render('TonyUserBundle:Default:callback.html.twig', array(
                    'callback_handler' => "Connection token received:".$em));

        }
        else
        {

            return $this->render('TonyUserBundle:Default:callback.html.twig', array('callback_handler' => "No connection token received"));

        }


    }


}


