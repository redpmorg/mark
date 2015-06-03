<?php
/**
 * Logged User Utils
 * @authors Leonard LEPADATU (lepadatu.leonard-ext@groupehn.com)
 * @date    2015-06-03 13:22:00
 * @version $Id$
 */

namespace Mark\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class UserUtilsController extends Controller
{

	public function indexAction()
	{

		dump($this);

// dump($this->get('security.token_storage'));

		// $roles = Controller::get('security.token_storage')->getToken()->getRoles();
		// foreach($roles as $role)
		// {
		// 	$role = str_replace("_", " ", substr($role->getRole(), 5));
		// }
		// switch($role) {
		// 	case "USER":
		// 	$roleId = 0;
		// 	break;
		// 	case "ADMIN":
		// 	$roleId = 1;
		// 	break;
		// 	case "SUPER_ADMIN":
		// 	$roleId = 2;
		// 	break;
		// }
		$roleId = 1;
		return $roleId;
	}

}