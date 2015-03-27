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
     * @var integer
     * @ORM\OneToOne(targetEntity="UserSocialLink", mappedBy="User")
     */
    private $user;





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
     * Set userToken
     *
     * @param \Tony\UserBundle\Entity\UserSocialLink $userToken
     * @return User
     */
    public function setUserToken(\Tony\UserBundle\Entity\UserSocialLink $userToken = null)
    {
        $this->userToken = $userToken;

        return $this;
    }

    /**
     * Get userToken
     *
     * @return \Tony\UserBundle\Entity\UserSocialLink 
     */
    public function getUserToken()
    {
        return $this->userToken;
    }

    /**
     * Set user
     *
     * @param \Tony\UserBundle\Entity\UserSocialLink $user
     * @return User
     */
    public function setUser(\Tony\UserBundle\Entity\UserSocialLink $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Tony\UserBundle\Entity\UserSocialLink 
     */
    public function getUser()
    {
        return $this->user;
    }
}
