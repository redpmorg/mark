<?php

namespace Mark\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mark\GeneralBundle\Controller\DefaultController as Utils;

class DefaultController extends Controller
{

	/**
	 * Index Action
	 * @Template("MarkMenuBundle:Default:index.html.twig")
	 */
	public function indexAction()
	{

		$user = $this->get('security.token_storage')->getToken()->getUser();

		$data["user_fname"] = $user->getFirstname();
		$data["user_role"] = $user->getRoles();

		return $data;

	}
}
