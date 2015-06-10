<?php
/**
 * Logged User Utils functions
 * @authors Leonard LEPADATU (lepadatu.leonard-ext@groupehn.com)
 * @date    2015-06-03 13:22:00
 * @version $Id$
 */

namespace Mark\LoginBundle\Controller;

use Mark\LoginBundle\Entity\Users;

class UserUtilsController
{

	private $token;

	/**
	 * Construct $token from DI services container
	 *
	 * @param abject $token Injected by services container
	 */
	public function __construct($token)
	{
		$this->token = $token;
	}

	/**
	 * Get logged user id
	 *
	 * @return  int
	 */

	public function getUserId()
	{
		return $this->token->getToken()->getUser()->getId();
	}

	/**
	 * Get logged user ROLE ID
	 *
	 * @return int RoleId
	 */
	public function getUserRoleId()
	{
		$roles = $this->token->getToken()->getRoles();
		foreach($roles as $role)
		{
			$role = str_replace("_", " ", substr($role->getRole(), 5));
		}
		$roleId = 0;
		switch($role) {
			case "USER":
			$roleId = 0;
			break;
			case "ADMIN":
			$roleId = 1;
			break;
			case "SUPER ADMIN":
			$roleId = 2;
			break;
		}
		return $roleId;
	}

	/**
	 * Get logged user ROLE NAME
	 *
	 * @return string
	 */
	public function getUserRoleName()
	{
		$roles = $this->token->getToken()->getRoles();
		foreach($roles as $role)
		{
			$role = str_replace("_", " ", substr($role->getRole(), 5));
		}
		return $role;
	}

	/**
	 * Get logged user FirstName
	 *
	 * @return string
	 */
	public function getUserFirstname()
	{
		return $this->token->getToken()->getUser()->getFirstname();
	}


	/**
	 * Get logged users parameters
	 *
	 * @return serialized string
	 */
	public function getUserParameter()
	{
		return $this->token->getToken()->getUser()->getParam();
	}

}