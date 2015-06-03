<?php

namespace Mark\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Mark\MenuBundle\Entity\Menu;


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

		$menu = new Menu();
		$menu->getDoctrine()->getManager();

		return $data;

	}

	/**
	 * @Route("/persistMenu", name="_persist_menu")
	 */
	public function menuPersistForTestingPurpose()
	{

		return false;
	}
}
