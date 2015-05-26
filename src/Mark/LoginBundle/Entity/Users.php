<?php

namespace Mark\LoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class Users implements UserInterface, \Serializable
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
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
	 * @ORM\Column(name="user_role", type="string", length=64)
	 */
	 private $user_role;



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
		$this->password = $password;

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
	 * @return  String
	 */

	public function getUserRole()
	{
		return $this->user_role;
	}

	/**
	 * Set user_role
	 *
	 * @param string $user_role
	 * @return  user_role
	 */

	public function setUserRole($user_role)
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


	public function getRoles()
	{
		return array('ROLE_USER');
	}

	public function eraseCredentials()
	{
	}


}
