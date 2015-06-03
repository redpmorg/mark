<?php

namespace Mark\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\component\DependencyInjection\ContainerAwareInterface;

class UserUtilsController extends Controller
{

	public function getRoleId() {

		foreach($this->roles as $role)
		{
			$role = str_replace("_", " ", substr($role->getRole(),5));
		}

		switch($role) {
			case "USER":
			$r = 0;
			break;
			case "ADMIN":
			$r = 1;
			break;
			case "SUPER_ADMIN":
			$r = 2;
			break;
		}
		return $r;
	}

	public function getRoleName() {

		foreach($this->roles as $role)
		{
			$role = str_replace("_", " ", substr($role->getRole(),5));
		}

		return $role;
	}

}
