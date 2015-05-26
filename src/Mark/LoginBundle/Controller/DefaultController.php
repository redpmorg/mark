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
	 * @Route("/", name="_login")
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
	 * @Template("MarkLoginBundle:Default:login-check.html.twig")
	 */
	public function loginCheckAction()
	{
		return array("_message"=>"Secured area");
	}

	/**
	 * @Route("/login_failure", name="_login_failure")
	 * @Template("MarkLoginBundle:Default:login-failure.html.twig")
	 */
	public function loginFailureAction() 
	{
		return array("_message"=>"A failure of login action!");
	}

}