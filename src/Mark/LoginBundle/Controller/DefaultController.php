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
	 * @Route("/login", name="_login")
	 * @Template("MarkLoginBundle:Default:login.html.twig")
	 */

	public function loginAction() {


$request = $this->get('request');
dump($request->getSession());


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
		return array("_message"=>"This is secured area");
	}
}