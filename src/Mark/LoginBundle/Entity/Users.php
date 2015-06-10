<?php

namespace Mark\LoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Users
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Users implements UserInterface, \Serializable
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
	 * @ORM\Column(name="firstName", type="string", length=50)
	 */
	private $firstname;

	/**
	 * @ORM\Column(name="lastName", type="string", length=50)
	 */
	private $lastname;

	/**
	 * @ORM\Column(name="username", type="string", length=50, unique=true, nullable=false)
	 */
	private $username;

	/**
	 * @ORM\Column(name="email", type="string", length=50)
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="password", type="string", length=64)
	 */
	private $password;

	/**
	 * @ORM\Column(name="is_active", type="boolean")
	 */
	private $isActive;


	/**
	 * @ORM\Column(name="user_role", type="integer", length=2)
	 */
	private $user_role;

	/**
	 * @ORM\Column(name="locale", type="string", length=3)
	 */
	private $locale;

	/**
	 * @ORM\Column(name="user_param", type="array", nullable=true)
	 */
	private $user_param;

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
	 * Set firstname
	 *
	 * @param string $firstname
	 * @return Users
	 */
	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;

		return $this;
	}

	/**
	 * Get firstname
	 *
	 * @return string
	 */
	public function getFirstname()
	{
		return $this->firstname;
	}

	/**
	 * Set lastname
	 *
	 * @param string $lastname
	 * @return Users
	 */
	public function setLastname($lastname)
	{
		$this->lastname = $lastname;

		return $this;
	}

	/**
	 * Get lastname
	 *
	 * @return string
	 */
	public function getLastname()
	{
		return $this->lastname;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 * @return Users
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
	 * Set password
	 *
	 * @param string $password
	 * @return Users
	 */
	public function setPassword($password)
	{
		$this->password = password_hash($password, PASSWORD_BCRYPT, array("cost"=>12));

		return $this;
	}

	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Get Username
	 *
	 * @return  String
	 */

	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Set username
	 *
	 * @param string $username
	 * @return  Username
	 */

	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * Get user_role
	 *
	 * @return  []
	 */

	public function getRoles()
	{
		switch ($this->user_role) {
			case 0:
			$ur = "ROLE_USER";
			break;
			case 1:
			$ur = "ROLE_ADMIN";
			break;
			case 2:
			$ur = "ROLE_SUPER_ADMIN";
			break;
		}

		return array($ur);
	}

	/**
	 * Set user_role
	 *
	 * @param string $user_role
	 * @return  user_role
	 */

	public function setRoles($user_role)
	{
		$this->user_role = $user_role;
	}


	public function getSalt()
	{
		return null;
	}


	/** @see \Serializable::serialize() */
	public function serialize()
	{
		return serialize(array(
			$this->id,
			$this->username,
			$this->password
			));
	}

	/** see \Serializable::unserialize() */
	public function unserialize($serialized)
	{
		list (
			$this->id,
			$this->username,
			$this->password
			) = unserialize($serialized);
	}

	public function eraseCredentials()
	{
	}

	/**
	 * Set isActive
	 *
	 * @param boolean $isActive
	 * @return Users
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
	 * Set user_role
	 *
	 * @param string $userRole
	 * @return Users
	 */
	public function setUserRole($userRole)
	{
		$this->user_role = $userRole;

		return $this;
	}

	/**
	 * Get user_role
	 *
	 * @return string
	 */
	public function getUserRole()
	{
		return $this->user_role;
	}


	/**
	 * Set locale
	 *
	 * @param string $locale
	 * @return Users
	 */
	public function setLocale($locale)
	{
		$this->locale = $locale;

		return $this;
	}

	/**
	 * Get locale
	 *
	 * @return string
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**	* Get user parametrs
	*
	* @return array
	*/
	public function getParam()
	{
		return $this->user_param;
	}

	/**
	* Set user parameters
	* @param  $user_param array
	* @return UserParams
	*/
	public function setParam($user_param)
	{
		$this->user_param = $user_param;

		return $this;
	}


    /**
     * Set user_param
     *
     * @param array $userParam
     * @return Users
     */
    public function setUserParam($userParam)
    {
        $this->user_param = $userParam;

        return $this;
    }

    /**
     * Get user_param
     *
     * @return array 
     */
    public function getUserParam()
    {
        return $this->user_param;
    }
}
