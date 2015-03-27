<?php


namespace Tony\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="member")
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
    private $userToken;





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
}
