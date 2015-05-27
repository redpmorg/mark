<?php

namespace Mark\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

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
	 * @Route("/secured", name="_login")
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
	 * @Template("MarkLoginBundle:Default:login-failure.html.twig")
	 */
	public function loginFailureAction()
	{
		return array("_message"=>"Login failure!");
	}

	/**
	 * @Route("/secured_areea", name="_login_succeded")
	 * @Template("MarkLoginBundle:Default:logged.html.twig")
	 */
	public function loggedAction(){

		if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
			return array("_message"=>"ADMIN SECURED AREEA!");
		} else {
			return array("_message"=>"COMMON SECURED AREEA!");
		}
	}

}