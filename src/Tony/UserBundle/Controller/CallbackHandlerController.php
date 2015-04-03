<?php

namespace Tony\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\Null;
use Tony\UserBundle\Entity\User;
class CallbackHandlerController extends Controller
{

    public function linkuserAction($user_token, $user_id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TonyUserBundle:User')->find($user_id);

        $user->setUserSocialLinkToken($user_token);
        $em->flush();

        // Execute the query: INSERT INTO user_social_link SET user_token = <user_token>, user_id = <user_id>
        // Nothing has to be returned
    }

    public function unlinkuserAction($user_id){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TonyUserBundle:User')->find($user_id);

        $user->setUserSocialLinkToken(null);
        $em->flush();

        // Execute the query: DELETE FROM user_social_link WHERE user_token = <user_token> AND user_id = <user_id>
        // Nothing has to be returned
    }


    public function indexAction()
    {

        $request = Request::createFromGlobals();

        $conn_token = $request->request->get('connection_token');
//        $conn_token = "2d90d6c5cfe345da296bc9446bb29f38e88d5632";
        if ( ! empty ($conn_token))
        {

            //Your Site Settings
//            $site_subdomain = $this->config["site_subdomain"];
//            $site_public_key = $this->container->getParameter('site_public_key');
//            $site_private_key = $this->container->getParameter('site_private_key');

            $site_subdomain ="tamagodb";
            $site_public_key = "c226b0ee-d594-4c0c-b70d-c6dfdb595d2b";
            $site_private_key = "8b8ee72b-1e04-487c-b89a-ee57ac3932c8";

            //API Access domain
            $site_domain = $site_subdomain.'.api.oneall.com';

            //Connection Resource
            $resource_uri = 'https://'.$site_domain.'/connections/'.$conn_token .'.json';

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
                                          "Curl info:". curl_getinfo($curl)));
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


                    $user_token = $data->user->user_token;

                    $em = $this->getDoctrine()
                        ->getManager();



                    $user = $this->get('security.context')->getToken()->getUser();
                    $user_id=$user->getId();
                    $user_stored_token=$user->getUserSocialLinkToken();

                    //var_dump(user);
                    //exit;



                    if (!$user_stored_token)
                    {

                        $this->linkuserAction($user_token,$user_id);
                        $user_stored_new_token=$user->getUserSocialLinkToken();

                        return $this->render('TonyUserBundle:Default:callback.html.twig', array(
                                'callback_handler' => $user_stored_new_token));
                    }
                    else
                    {
                        //return $this->redirect($this->generateUrl('tony_main_account'));
                        //$this->unlinkuserAction($user_id);
                        $user_stored_new_token=$user->getUserSocialLinkToken();
                        return $this->render('TonyUserBundle:Default:callback.html.twig', array(
                                'callback_handler' => "token already exist：".$user_stored_new_token));
                    }

                }
                elseif ($data->plugin->key == 'social_link')
                {
                    //Operation successfull
                    if ($data->plugin->data->status == 'success')
                    {
//                        //Identity linked
//                        if ($data->plugin->data->action == 'link_identity')
//                        {
//                            //The identity <identity_token> has been linked to the user <user_token>
//                            $user_token = $data->user->user_token;
//                            $identity_token = $data->user->identity->identity_token;
//
//                            //Next Step:
//                            // 1] Get _your_ $userid from _your_ SESSION DATA
//                            // 2] Check if the $userid is linked to this user_token: GetUserIdForUserToken($user_token)
//                            // 2.1] If not linked, tie the <user_token> to this userid : LinkUserTokenToUserId($user_token, $user_id)
//                            // 3] Redirect the user to the account linking page
//                        }
//                        //Identity Unlinked
//                        elseif ($data->plugin->data->action == 'unlink_identity')
//                        {
//                            //The identity <identity_token> has been unlinked from the user <user_token>
//                            $user_token = $data->user->user_token;
//                            $identity_token = $data->user->identity->identity_token;
//
//                            //Next Step:
//                            // 1] At your convenience
//                            // 2] Redirect the user to the account linking page
//                        }
                        return $this->render('TonyUserBundle:Default:callback.html.twig', array('callback_handler' => "Doing social linking"));
                    }
                }
            }


        }

        return $this->render('TonyUserBundle:Default:callback.html.twig', array('callback_handler' => "No connection token received"));
    }


}


