<?php

namespace Tony\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSocialLink
 *
 * @ORM\Table(name="user_social_link")
 * @ORM\Entity(repositoryClass="Tony\UserBundle\Entity\UserSocialLinkRepository")
 */
class UserSocialLink
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\OneToOne(targetEntity="User", inversedBy="UserSocialLink")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_token", type="string", length=255)
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
     * Set userId
     *
     * @param integer $userId
     * @return UserSocialLink
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set userToken
     *
     * @param string $userToken
     * @return UserSocialLink
     */
    public function setUserToken($userToken)
    {
        $this->userToken = $userToken;

        return $this;
    }

    /**
     * Get userToken
     *
     * @return string
     */
    public function getUserToken()
    {
        return $this->userToken;
    }
}
