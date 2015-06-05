<?php

namespace Mark\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\Security\Core\Security;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LoginController extends Controller
{

	/**
	* @Route("/", name="public_areea")
	* @Template("MarkLoginBundle:Default:index.html.twig")
	*/
	public function indexAction()
	{
		$data["title"] = "PUBLIC AREEA";
		return $data;
	}


	/**
	 * @Route("/login", name="login")
	 * @Template("MarkLoginBundle:Default:login.html.twig")
	 */
	public function loginAction()
	{
		$authenticationUtils = $this->get('security.authentication_utils');
		$lastError = $authenticationUtils->getLastAuthenticationError();
		$lastUserName = $authenticationUtils->getLastUserName();

		$data["title"] = "PUBLIC AREEA";
		$data["_username"] = $lastUserName;
		$data["_error"] = $lastError;

		return $data;
	}

	/**
	 * @Route("/login_check", name="login_check")
	 */
	public function loginCheckAction()
	{
		//this controller is handeled by Security system
	}

	/**
	 * @Route("/secured_failure", name="login_failure")
	 */
	public function loginFailureAction()
	{
		return $this->redirectToRoute('login');
	}

	/**
	 * @Route("/com", name="common_login_succeded")
	 * @Route("/adm", name="admin_login_succeded")
	 * @Route("/sadm", name="sadmin_login_succeded")
	 * @Template("MarkLoginBundle:Default:logged.html.twig")
	 */
	public function loggedAction(){

		$user_role = $this->get('user.loggeduser_utils')->getUserRoleName();

		$data["title"] = $user_role. " AREEA";

		return $data;

	}

}