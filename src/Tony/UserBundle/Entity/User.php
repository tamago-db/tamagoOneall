<?php


namespace Tony\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;



    /**
     * @ORM\Column(name="user_social_link_token", type="string", length=36)
     */
    protected $userSocialLinkToken;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userSocialLinkToken
     *
     * @param string $userSocialLinkToken
     * @return User
     */
    public function setUserSocialLinkToken($userSocialLinkToken)
    {
        $this->userSocialLinkToken = $userSocialLinkToken;

        return $this;
    }

    /**
     * Get userSocialLinkToken
     *
     * @return string 
     */
    public function getUserSocialLinkToken()
    {
        return $this->userSocialLinkToken;
    }
}
