<?php

namespace Tony\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tony\UserBundle\Entity\UserSocialLink;
use Tony\UserBundle\Entity\User;
class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TonyUserBundle:Default:index.html.twig', array('name' => $name));
    }



    public function LinkUserTokenToUserId($user_token, $user_id){

        $user_social_link = new UserSocialLink();
        $user_social_link->setUserId($user_id);
        $user_social_link->setUserToken($user_token);

        $user = new User();
        $user->setSociallinkId($user_id);



        $em = $this->getDoctrine()->getEntityManager();

        $em->persist($user_social_link);
        $em->persist($user);
        $em->flush();

        // Execute the query: INSERT INTO user_social_link SET user_token = <user_token>, user_id = <user_id>
        // Nothing has to be returned

    }




}
