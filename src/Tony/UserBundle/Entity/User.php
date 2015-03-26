<?php
// src/Acme/UserBundle/Entity/User.php

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     *
     * @ORM\Column(type="string")
     */
    protected $user_token;




    /**
     * Get user_token
     *
     * @return string
     */
    public function getUser_token()
    {
        return $this->user_token;
    }

}
