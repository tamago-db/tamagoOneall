<?php
/**
 * Created by PhpStorm.
 * User: runcong
 * Date: 3/27/15
 * Time: 6:11 PM
 */

namespace Tony\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\Null;

class UserRepository extends EntityRepository
{


    public function GetUserIdForUserToken($user_token){

        $query = $this->createQueryBuilder('u')
            ->select('u.id')
            ->where('u.userSocialLinkToken = :user_token')
            ->setParameter('user_token', $user_token)
            ->getQuery();

        return $query->getResult();
        // Execute the query: SELECT user_id FROM user_social_link WHERE user_token = <user_token>
        // Return the user_id or null if none found.
    }

    public function GetUserTokenForUserId($user_id){

        $qu = $this->createQueryBuilder('u')
            ->select('u.userSocialLinkToken')
            ->where('u.id = :user_id')
            ->setParameter('user_id', $user_id);

        return $qu->getQuery()
            ->getResult();
        // Execute the query: SELECT user_token FROM user_social_link WHERE user_id = <user_id>
        // Return the user_token or null if none found.

    }

    public function UnlinkUserTokenFromUserId($user_token, $user_id){

        $this->createQueryBuilder('u')
            ->update('TonyUserBundle:User','u')
            ->set('u.userSocialLinkToken', Null)
            ->where('u.userSocialLinkToken = :user_token ')
            ->andWhere ('u.id = :user_id')
            ->setParameter('user_token', $user_token)
            ->setParameter('user_id', $user_id);

        // Execute the query: DELETE FROM user_social_link WHERE user_token = <user_token> AND user_id = <user_id>
        // Nothing has to be returned
    }

    public function LinkUserTokenToUserId($user_token, $user_id){

        $this->createQueryBuilder('u')
            ->update('TonyUserBundle:User','u')
            ->set('u.userSocialLinkToken', $user_token)
            ->Where ('u.id = :user_id')
            ->setParameter('user_id', $user_id);

        // Execute the query: INSERT INTO user_social_link SET user_token = <user_token>, user_id = <user_id>
        // Nothing has to be returned

    }
}