<?php

namespace Renaissance\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * User
 *
 * @ORM\Table(name="User")
 * @ORM\Entity
 */
class User implements UserInterface, \Serializable
{
     /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=false)
     */
    private $username;


    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="canvas_user_id", type="integer")
     */
    private $canvas_user_id;

    /**
     * @ORM\Column(name="avatar_url", type="string",length=255)
     */
    private $avatar_url = "bundles/renaissanceweb/img/default/avatar.png";




    private $password;

    
    
    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            //$this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }


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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set canvas_user_id
     *
     * @param integer $canvasUserId
     * @return User
     */
    public function setCanvasUserId($canvasUserId)
    {
        $this->canvas_user_id = $canvasUserId;

        return $this;
    }

    /**
     * Get canvas_user_id
     *
     * @return integer 
     */
    public function getCanvasUserId()
    {
        return $this->canvas_user_id;
    }

    /**
     * Set avatar_url
     *
     * @param string $avatar_url
     * @return User
     */
    public function setAvatarUrl($avatar_url)
    {
        $this->avatar_url = $avatar_url;

        return $this;
    }

    /**
     * Get avatar_url
     *
     * @return string 
     */
    public function getAvatarUrl()
    {
        return $this->avatar_url;
    }
}
