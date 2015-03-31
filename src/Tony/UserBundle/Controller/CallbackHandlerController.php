<?php

namespace Tony\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Tony\UserBundle\Entity\User;
class CallbackHandlerController extends Controller
{
    public function indexAction()
    {

        $request = Request::createFromGlobals();

        $user_token = $request->request->get('connection_token');
        if ( ! empty ($user_token))
        {

            //Your Site Settings
            $site_subdomain = $this->container->getParameter('site_subdomain');
            $site_public_key = $this->container->getParameter('site_public_key');
            $site_private_key = $this->container->getParameter('site_private_key');

            //API Access domain
            $site_domain = $site_subdomain.'.api.oneall.com';

            //Connection Resource
            $resource_uri = 'https://'.$site_domain.'/connections/'.$$user_token .'.json';

            //Setup connection
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $resource_uri);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_USERPWD, $site_public_key . ":" . $site_private_key);
            curl_setopt($curl, CURLOPT_TIMEOUT, 15);
            curl_setopt($curl, CURLOPT_VERBOSE, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_FAILONERROR, 0);

            //Send request
            $result_json = curl_exec($curl);

            //Error
            if ($result_json === false)
            {

                curl_close($curl);

                return $this->render('TonyUserBundle:Default:callback.html.twig', array(
                    'callback_handler' => "Curl error:". curl_error($curl). '<br />'.
                                          "Curl info:". curl_getinfo($curl). '<br />'));

            }
            //Success
            else
            {
                curl_close($curl);

                $json = json_decode ($result_json);

                //Extract data
                $data = $json->response->result->data;

                //Check for plugin
                if ($data->plugin->key == 'social_login')
                {


                    return $this->redirect($this->generateUrl('tony_main_account'));
//                    return $this->render('TonyUserBundle:Default:callback.html.twig', array(
//                            'callback_handler' => "login successfully"));
                }
                elseif ($data->plugin->key == 'social_link')
                {
                    //Operation successfull
                    if ($data->plugin->data->status == 'success')
                    {
                        //Identity linked

                        $session = new Session();
                        $session->start();
                        $user_id=$session->get('userid');

                        if ($data->plugin->data->action == 'link_identity')
                        {
                            //The identity <identity_token> has been linked to the user <user_token>

                            $user_token = $data->user->user_token;
                            $identity_token = $data->user->identity->identity_token;

                            $em = $this->getDoctrine()
                                ->getManager();


                            $id= $em->getRepository('TonyUserBundle:User')
                                ->GetUserIdForUserToken($user_token);
                            if (! $user_id==$id)
                            {
                                $em->getRepository('TonyUserBundle:User')
                                    ->LinkUserTokenToUserId($user_token, $user_id);

                                return $this->redirect($this->generateUrl('tony_main_account'));
                            }



                        }
                        //Identity Unlinked
                        elseif ($data->plugin->data->action == 'unlink_identity')
                        {
                            //The identity <identity_token> has been unlinked from the user <user_token>
                            $user_token = $data->user->user_token;
                            $identity_token = $data->user->identity->identity_token;

                            $em->getRepository('TonyUserBundle:User')
                                ->UnLinkUserTokenToUserId($user_token, $user_id);

                            return $this->redirect($this->generateUrl('tony_main_account'));
                        }
                    }
                }
            }





//            return $this->render('TonyUserBundle:Default:callback.html.twig', array(
//                    'callback_handler' => "Connection token received:".$em));

        }



        else
        {

            return $this->render('TonyUserBundle:Default:callback.html.twig', array('callback_handler' => "No connection token received"));

        }


    }


}


