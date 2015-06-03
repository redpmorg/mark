<?php
/**
 * Logged User Utils
 * @authors Leonard LEPADATU (lepadatu.leonard-ext@groupehn.com)
 * @date    2015-06-03 13:22:00
 * @version $Id$
 */

namespace Mark\LoginBundle\Controller;

class UserUtilsController
{

	private $token;

	public function __construct($token)
	{
		$this->token = $token;
	}

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

	public function getUserRoleName()
	{

		$roles = $this->token->getToken()->getRoles();

		foreach($roles as $role)
		{
			$role = str_replace("_", " ", substr($role->getRole(), 5));
		}

		return $role;

	}

	public function getUserFirstname()
	{

		return $this->token->getToken()->getUser()->getFirstname();

	}

}