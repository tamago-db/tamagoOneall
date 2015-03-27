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
    private $sociallinkId;




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
     * Set sociallinkId
     *
     * @param \Tony\UserBundle\Entity\UserSocialLink $sociallinkId
     * @return User
     */
    public function setSociallinkId(\Tony\UserBundle\Entity\UserSocialLink $sociallinkId = null)
    {
        $this->sociallinkId = $sociallinkId;

        return $this;
    }

    /**
     * Get sociallinkId
     *
     * @return \Tony\UserBundle\Entity\UserSocialLink 
     */
    public function getSociallinkId()
    {
        return $this->sociallinkId;
    }
}
