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
	 * @Route("/secured_areea", name="_login_succeded")
	 * @Template("MarkLoginBundle:Default:logged.html.twig")
	 */
	public function loggedAction(){

		$data = array();

		if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {

			$data['title'] = "Admin areea";
			$data['menu'] = "admin";

		} elseif ($this->get('security.context')->isGranted('ROLE_USER')) {

			$data['title'] = "User areea";
			$data['menu'] = "user";

		} else {

			return $this->redirectToRoute('_login_failure', array(), 301);

		}

		return $data;
	}

}