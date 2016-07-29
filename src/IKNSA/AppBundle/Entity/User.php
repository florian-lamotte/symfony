<?php
// srcIKNSA//AppBundle/Entity/User.php

namespace IKNSA\AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
    * Set user
    * @param \IKNSA\AppBundle\Entity\User $user
    * @return Post
    */
    public function setUser(\IKNSA\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
    * Get user
    * @return \IKNSA\AppBundle\Entity\User
    */
    public function getUser()
    {
        return $this->user;
    }
}
