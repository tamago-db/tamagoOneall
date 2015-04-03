<?php

namespace Tony\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PublishController extends Controller
{

    public function messageAction()
    {

        $user = $this->get('security.context')->getToken()->getUser();
        $user_id=$user->getId();
        $user_token = $user->getUserSocialLinkToken();



        $site_subdomain ="tamagodb";
        $site_public_key = "c226b0ee-d594-4c0c-b70d-c6dfdb595d2b";
        $site_private_key = "8b8ee72b-1e04-487c-b89a-ee57ac3932c8";

        //The resource to send the request to
        $api_resource_uri = 'https://'.$site_subdomain . ".api.oneall.com/sharing/messages.json";

        //The POST data to be included
        $post_data = array(
            'request' => array(
                'sharing_message' => array(
                    'parts' => array(
                        'text' => array(
                            'body' => 'oneall simplifies the integration of social networks for Web 2.0 and SaaS companies'
                        ),
                        'picture' => array(
                            'url' => 'http://oneallcdn.com/img/heading/slides/provider_grid.png'
                        ),
                        'link' => array(
                            'url' => 'http://www.oneall.com/',
                            'name' => 'oneall.com',
                            'caption' => 'Social Media Integration',
                            'description' => 'Easily integrate social services like Facebook, Twitter, LinkedIn and Foursquare with your already-existing website.'
                        ),
                        'flags' => array(
                            'enable_tracking' => 1
                        )
                    ),
                    'publish_for_user' => array(
                        'user_token' => $user_token,
                        //'providers' => array('facebook', 'twitter', 'linkedin')
                        'providers' => array('twitter')
                    )
                )
            )
        );

        //Setup CURL
        $curl = curl_init ();
        curl_setopt_array ($curl, array (
                CURLOPT_URL => $api_resource_uri,
                CURLOPT_USERPWD => $site_public_key . ":" . $site_private_key,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($post_data)
            ));

        //Send Request
        $data = curl_exec ($curl);


//        if ($data === false)
//        {
//            echo 'Curl Error: ' . curl_error ($curl);
//        }
//
//        else
//        {
//            echo 'Received Result: ' . $data;
//        }

        //Close connection
        curl_close ($curl);



        return $this->render('TonyMainBundle:Pages:message.html.twig', array(
                'message1'      => $user_token,
                'message2'  => "testing"
            ));
    }
}




