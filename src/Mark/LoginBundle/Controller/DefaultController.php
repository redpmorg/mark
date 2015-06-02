<?php

namespace Mark\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DefaultController extends Controller
{

	/**
	* @Route("/", name="_public")
	* @Template("MarkLoginBundle:Default:index.html.twig")
	*/
	public function indexAction()
	{
		return array("_message" => "PUBLIC AREEA");
	}


	/**
	 * @Route("/login", name="_login")
	 * @Template("MarkLoginBundle:Default:login.html.twig")
	 */
	public function loginAction()
	{

		$authenticationUtils = $this->get('security.authentication_utils');
		$lastError = $authenticationUtils->getLastAuthenticationError();
		$lastUserName = $authenticationUtils->getLastUserName();

		return array("_username" => $lastUserName, "_error" => $lastError);
	}

	/**
	 * @Route("/login_check", name="_login_check")
	 */
	public function loginCheckAction()
	{
		//this controller is handeled by Security system
	}

	/**
	 * @Route("/secured_failure", name="_login_failure")
	 */
	public function loginFailureAction()
	{
		return $this->redirectToRoute('_login');
	}

	/**
	 * @Route("/com", name="_login_succeded")
	 * @Template("MarkLoginBundle:Default:logged.html.twig")
	 */
	public function loggedAction(){

		$user_role = $this->get('security.token_storage')->getToken()->getRoles();
		foreach($user_role as $role)
		{
			$role = str_replace("_", " ", substr($role->getRole(),5));
		}

		$data = array();
		$data['title'] = $role. " AREEA";
		$data['role'] = $role;

		return $data;

	}

}