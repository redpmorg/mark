<?php

namespace Mark\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


class DefaultController extends Controller
{
	/**
	 * @Route("/", name="login")
	 * @Template("MarkLoginBundle:Default:login.html.twig")
	 */

	public function loginAction(Request $request) {

		$session = $request->getSession();

		if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		} else {
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}

		return array("_username" => $session->get(SecurityContext::LAST_USERNAME), "error" => $error);
	}

	/**
	 * @Route("/login_check", name="login_check")
	 * @Template()
	 */
	public function loginCheckAction()
	{

	}
}


// public function loginAction()
	// {
	//     $request = $this->getRequest();
	//     $session = $request->getSession();

	//     // get the login error if there is one
	//     if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
	//         $error = $request->attributes->get(
	//             SecurityContext::AUTHENTICATION_ERROR
	//         );
	//     } else {
	//         $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
	//         $session->remove(SecurityContext::AUTHENTICATION_ERROR);
	//     }

	//     return $this->render(
	//         'AcmeSecurityBundle:Security:login.html.twig',
	//         array(
	//             // last username entered by the user
	//             'last_username' => $session->get(SecurityContext::LAST_USERNAME),
	//             'error'         => $error,
	//         )
	//     );
	// }

	// public function dumpStringAction()
	// {
	//   return $this->render('SimpleProfileBundle:Security:dumpString.html.twig', array());
	// }